<script>
    import {goto} from "$app/navigation";
    import {onMount} from "svelte";
    let token = '';
    const apiUrl = import.meta.env.VITE_API_URL;
    if(typeof window !== 'undefined') {
        $: token = localStorage.getItem('token');
    }
    async function back() {
        goto("/app")
    }

    onMount(async () => {
        const data = {
            status: "pending"
        }
        let bookings = await fetch(apiUrl + '/bookings/all', {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
            body: JSON.stringify(data)
        })
        bookings = await bookings.json()
    })
</script>
<div class="container flex items-center bg-white p-[32px] w-full mx-auto rounded-[20px]">
    <img on:click={back} class="hover:opacity-[0.8] transition-all cursor-pointer" src="https://cdn.360mesto.ru/landing/backbutton.png" alt="">
    <h2 class="text-[32px] font-[600] text-[#020617] ml-[2%]">Заявки</h2>
</div>
<div class="container grid grid-cols-3 gap-3 w-full mx-auto rounded-[20px]">
    <div class="bg-white w-full p-[16px] rounded-[16px] mt-[5%]">
        <h2 class="text-[19px] font-[600] text-[#020617]">Заявка №3821</h2>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <p class="text-[#92979F] text-[12px] font-[400]">Номер</p>
                <p class="text-[#414751] text-[14px] font-[400] text-center">+79142260516</p>
            </div>
            <div>
                <p class="text-[#92979F] text-[12px] font-[400]">Почта</p>
                <p class="text-[#414751] text-[14px] font-[400] text-center">aytalandreew13@gmail.com</p>
            </div>
        </div>
        <div class="grid grid-cols-2 grid-rows-2 gap-3 mt-[5%]">
            <div class="flex flex-col w-full h-full border border-[#235DFF] rounded-[24px]">
                <img class="mx-auto mt-auto mb-[10%]" src="https://cdn.360mesto.ru/landing/School.png" alt="">
                <p class="text-[20px] font-[600] text-[#020617] text-center mb-auto">Школы</p>
            </div>
            <div class="flex flex-col w-full h-full border border-[#235DFF] rounded-[24px]">
                <img class="mx-auto mt-auto mb-[10%]" src="https://cdn.360mesto.ru/landing/School.png" alt="">
                <p class="text-[20px] font-[600] text-[#020617] text-center mb-auto">Школы</p>
            </div>
            <div class="flex flex-col w-full h-full border border-[#235DFF] rounded-[24px]">
                <img class="mx-auto mt-auto mb-[10%]" src="https://cdn.360mesto.ru/landing/School.png" alt="">
                <p class="text-[20px] font-[600] text-[#020617] text-center mb-auto">Школы</p>
            </div>
            <div class="flex flex-col w-full h-full border border-[#235DFF] rounded-[24px]">
                <img class="mx-auto mt-auto mb-[10%]" src="https://cdn.360mesto.ru/landing/School.png" alt="">
                <p class="text-[20px] font-[600] text-[#020617] text-center mb-auto">Школы</p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-[5%]  ">
            <button class="bg-[#235DFF] rounded-[10px] py-[12px] px-[25] text-[15px] font-[400] text-white">Принять заявку</button>
            <button class="bg-[#E5ECFF] rounded-[10px] py-[12px] px-[25] text-[15px] font-[400] text-[#235DFF]">Отказать</button>
        </div>
    </div>
</div>