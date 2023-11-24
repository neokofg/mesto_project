<script>
    import {onMount} from "svelte";

    let token = '';
    let excursions = [];
    const apiUrl = import.meta.env.VITE_API_URL;
    if(typeof window !== 'undefined') {
        $: token = localStorage.getItem('token');
    }
    onMount(async () => {
        let response = await fetch(apiUrl + '/bookings/excursions', {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
        })
        response = await response.json()
        $: excursions = response.excursions
    })
</script>
<div class="container mx-auto">
    {#each excursions as excursion}
        <div class="flex justify-between bg-white rounded-[20px] p-[24px] mt-[3%]">
            <div>
                <p class="text-[24px] font-[600]">Дата</p>
                <p>{excursion.exDate}</p>
            </div>
            <p class="text-[24px] font-[600]">Записи:</p>
            {#each excursion.bookings as booking}
                <div>
                    <p class="font-[600] text-[18px]">Клиенты: <span class="font-[400]">{booking.clients}</span> </p>
                    <p class="font-[600] text-[18px]">Контакты: </p>
                    <p>email: {booking.email}</p>
                    <p>телефон: {booking.number}</p>
                </div>
            {/each}
        </div>
    {/each}
</div>