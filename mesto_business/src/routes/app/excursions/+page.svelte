<script>
    let token = '';
    let bookings = [];
    const apiUrl = import.meta.env.VITE_API_URL;
    if(typeof window !== 'undefined') {
        $: token = localStorage.getItem('token');
    }
    let date = '';
    let time = '';
    let selectedBookings = [];

    function convertToISO(dateStr, timeStr) {
        // Объединяем дату и время в одну строку
        const dateTimeStr = dateStr + 'T' + timeStr + ':00';

        // Создаем объект Date из строки
        const date = new Date(dateTimeStr);

        // Преобразуем в строку в формате ISO с учетом временной зоны UTC (добавляя '+00:00')
        const isoString = date.toISOString().replace('Z', '+00:00');

        return isoString;
    }
    async function search() {
        let response = await fetch(apiUrl + '/bookings/all?status=accepted&fromDate=' + date + '&toDate=' + date, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
        })
        response = await response.json()
        $: bookings = response.bookings
    }

    function selectBooking(bookingId) {
        selectedBookings.push(bookingId);
        let button = document.getElementById(bookingId);
        button.disabled = true;
    }

    async function excursion() {
        let data = {
            bookings: selectedBookings,
            exDate: convertToISO(date, time)
        }
        let response = await fetch(apiUrl + '/bookings/accept', {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
            body: JSON.stringify(data)
        })
        response = await response.json()
        console.log(response)
    }
</script>
<div class="container mx-auto">
    <label class="font-[600] text-[18px]" for="date">Выберите дату</label>
    <input class="py-[16px] border-[1px] rounded-[16px] px-[16px] mt-[1%]" bind:value={date} type="date" name="date">
    <button class="p-[16px] bg-[#235DFF] rounded-[16px] text-white" on:click={search}>Поиск</button>
    <br>
    <div class="grid grid-cols-3">
        {#each bookings as booking}
            <div class="flex p-[16px] flex-col bg-white rounded-[20px]">
                <div class="flex items-center">
                    <p class="font-[600] text-[24px]">Даты:</p>
                    <p class="font-[400] text-[18px] ml-[1%]">{booking.fromDate} - {booking.toDate}</p>
                </div>
                <p class="font-[400] text-[18px]"><span class="font-[600]">{booking.clients}</span> человек</p>
                <p>{booking.format} формат</p>
                <button id={booking.id} class="disabled:opacity-[0.5] p-[16px] bg-[#235DFF] rounded-[16px] text-white" on:click={selectBooking(booking.id)}>Выбрать</button>
            </div>
        {/each}
    </div>
    <label class="font-[600] text-[18px]" for="time">Выберите время</label>
    <form on:submit={excursion}>
    <input class="py-[16px] border-[1px] rounded-[16px] px-[16px] mt-[1%]" bind:value={time} type="time" name="time">
    <button class="p-[16px] bg-[#235DFF] rounded-[16px] text-white">Назначить экскурсию</button>
    </form>
</div>