<script>
    import {goto} from "$app/navigation";
    let name = '';
    let flat = '';
    let floor = '';
    let email = '';
    let isDisabled = false;
    const apiUrl = import.meta.env.VITE_API_URL;
    async function goBack() {
        goto('/app')
    }
    async function createResident(event) {
        event.preventDefault();
        let data = {
            name: name,
            flat: flat,
            floor: floor,
            email: email
        }
        let token = localStorage.getItem('token');
        isDisabled = true
        const response = await fetch(apiUrl + "/residents/generate_key", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
            body: JSON.stringify(data)
        })
        isDisabled = false;
        if (!response.ok) {
            alert(`Ошибка: ${response}`);
        } else {
            goto('/app')
        }
    }
</script>
<div class="bg-white mt-[10%] rounded-[20px] p-[20px] max-w-[619px] mx-auto">
    <form on:submit={createResident}>
        <div class="flex justify-between mb-[1%]">
            <h1 class="text-[24px] font-[600]">Новый резидент</h1>
            <img class="cursor-pointer hover:opacity-[0.5] transition-all" on:click={goBack} src="https://cdn.360mesto.ru/business/x.png" alt="">
        </div>
        <label class="text-[#9DA5B0] text-[16px] font-[400]" for="residentName">Название резидента</label>
        <input bind:value={name} class="hover:border-[#a2a4aa] focus:outline-none focus:border-[#235DFF] border border-[1px] rounded-[12px] p-[16px] w-full border-[#DDE0E8]" type="text" name="residentName" placeholder="Введите название" required>
        <div class="grid grid-cols-2 gap-6 justify-between my-[4%]">
            <div class="flex flex-col">
                <label class="text-[#9DA5B0] text-[16px] font-[400]" for="door">Кабинет</label>
                <input bind:value={flat} class="hover:border-[#a2a4aa] focus:outline-none focus:border-[#235DFF] w-full rounded-[12px] p-[16px] border border-[1px] border-[#DDE0E8]" type="text" name="door" placeholder="Введите номер" required>
            </div>
            <div class="flex flex-col">
                <label class="text-[#9DA5B0] text-[16px] font-[400]" for="floor">Этаж</label>
                <input bind:value={floor} class="hover:border-[#a2a4aa] focus:outline-none focus:border-[#235DFF] w-full rounded-[12px] p-[16px] border border-[1px] border-[#DDE0E8]" type="text" name="floor" placeholder="Введите этаж" required>
            </div>
        </div>
        <label class="text-[#9DA5B0] text-[16px] font-[400]" for="email">Электронная почта организации</label>
        <input bind:value={email} class="hover:border-[#a2a4aa] focus:outline-none focus:border-[#235DFF] w-full rounded-[12px] p-[16px] border border-[1px] border-[#DDE0E8]" type="email" name="email" placeholder="Email" required>
        <button type="submit" disabled={isDisabled} class="hover:opacity-[0.8] bg-blue-500 w-full rounded-[12px] text-white py-[16px] font-[400] text-[18px] mt-[4%]">Создать резидента</button>
    </form>
</div>