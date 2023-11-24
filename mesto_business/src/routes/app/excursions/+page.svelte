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
        selectedBookings.push(bookingId)
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
    <label for="date">Выберите дату</label>
    <input bind:value={date} type="date" name="date">
<!--    <label for="time">Выберите время</label>-->
<!--    <input bind:value={time} type="time" name="time">-->
    <button on:click={search}>Поиск</button>
    {#each bookings as booking}
        <div class="flex flex-col bg-white rounded-[20px]">
            <p>Даты</p>
            <p>{booking.fromDate} - {booking.toDate}</p>
            <p>{booking.clients} человек</p>
            <p>{booking.format} формат</p>
            <button on:click={selectBooking(booking.id)}>взять</button>
        </div>
    {/each}
    <label for="time">Выберите время</label>
    <form on:submit={excursion}>
    <input bind:value={time} type="time" name="time">
    <button>Назначить экскурсию</button>
    </form>
</div>