<script>
    import {goto} from "$app/navigation";
    import {onMount} from "svelte";
    let token = '';
    let bookings = [];
    let isLoaded = false;
    const apiUrl = import.meta.env.VITE_API_URL;
    if(typeof window !== 'undefined') {
        $: token = localStorage.getItem('token');
    }
    async function back() {
        goto("/app")
    }

    onMount(async () => {
        let response = await fetch(apiUrl + '/bookings/all?status=pending', {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
        })
        response = await response.json()
        $: bookings = response.bookings
        console.log(bookings);
        $: isLoaded = true;
    })

    async function approve(bookingId) {
        let data = {
            bookingId: bookingId,
            status: "accepted"
        }
        let accept = await fetch(apiUrl + '/bookings/', {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
            body: JSON.stringify(data)
        })
        accept = await accept.json()
        if(accept.ok) {
            window.location.reload()
        }
    }

    async function decline(bookingId) {
        let data = {
            bookingId: bookingId,
            status: "declined"
        }
        let decline = await fetch(apiUrl + '/bookings/', {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
            body: JSON.stringify(data)
        })
        decline = await decline.json()
        if(decline.ok) {
            window.location.reload()
        }
    }
</script>
<div class="container flex items-center bg-white p-[32px] w-full mx-auto rounded-[20px]">
    <img on:click={back} class="hover:opacity-[0.8] transition-all cursor-pointer" src="https://cdn.360mesto.ru/landing/backbutton.png" alt="">
    <h2 class="text-[32px] font-[600] text-[#020617] ml-[2%]">Заявки</h2>
</div>
<div class="flex">
    {#each bookings as booking}
        <div class="container grid grid-cols-3 gap-3 w-full mx-auto rounded-[20px]">
            <div class="bg-white w-full p-[16px] rounded-[16px] mt-[5%]">
                <h2 class="text-[19px] font-[600] text-[#020617]">Заявка {booking.id}</h2>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-[#92979F] text-[12px] font-[400]">Номер</p>
                        <p class="text-[#414751] text-[14px] font-[400] text-center">{booking.number}</p>
                    </div>
                    <div>
                        <p class="text-[#92979F] text-[12px] font-[400]">Почта</p>
                        <p class="text-[#414751] text-[14px] font-[400] text-center">{booking.email}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 grid-rows-2 gap-3 mt-[5%]">
                    <div class="flex py-[20px] flex-col w-full h-full border border-[#235DFF] rounded-[24px]">
                        <img class="mx-auto mt-auto mb-[10%]" src="https://cdn.360mesto.ru/landing/School.png" alt="">
                        <p class="text-[20px] font-[600] text-[#020617] text-center mb-auto">{booking.format}</p>
                    </div>
                    <div class="flex py-[20px] flex-col w-full h-full border border-[#235DFF] rounded-[24px]">
                        <p class="text-[25px] font-[600] text-[#020617] text-center text-[#235DFF] mt-auto mb-[10%]">{booking.clients}</p>
                        <p class="text-[20px] font-[600] text-[#020617] text-center">Участники</p>
                    </div>
                    <div class="flex py-[20px] flex-col w-full h-full border border-[#235DFF] rounded-[24px]">
                        <p class="text-[25px] font-[600] text-[#020617] text-center text-[#235DFF] mt-auto mb-[10%]">{booking.fromDate} <br> {booking.toDate}</p>
                        <p class="text-[20px] font-[600] text-[#020617] text-center mb-auto">Дата</p>
                    </div>
                    <div class="flex py-[20px] flex-col w-full h-full border border-[#235DFF] rounded-[24px]">
                        <p class="text-[25px] font-[600] text-[#020617] text-center text-[#235DFF] mt-auto mb-[10%]">В ожидании</p>
                        <p class="text-[20px] font-[600] text-[#020617] text-center mb-auto">Статус</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-[5%]  ">
                    <button on:click={approve(booking.id)} class="bg-[#235DFF] rounded-[10px] py-[12px] px-[25] text-[15px] font-[400] text-white">Принять заявку</button>
                    <button on:click={decline(booking.id)} class="bg-[#E5ECFF] rounded-[10px] py-[12px] px-[25] text-[15px] font-[400] text-[#235DFF]">Отказать</button>
                </div>
            </div>
        </div>
    {/each}
</div>