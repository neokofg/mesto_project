<script>
    import {goto} from "$app/navigation";

    async function goBack() {
        goto('/app')
    }
    async function createResident(event) {
        event.preventDefault();
        goto('/app')
    }
</script>
<div class="bg-white mt-[10%] rounded-[20px] p-[20px] max-w-[619px] mx-auto">
    <form on:submit={createResident}>
        <div class="flex justify-between mb-[1%]">
            <h1 class="text-[24px] font-[600]">Новый резидент</h1>
            <img on:click={goBack} src="/x.png" alt="">
        </div>
        <label class="text-[#9DA5B0] text-[16px] font-[400]" for="residentName">Название резидента</label>
        <input class="border border-[1px] rounded-[12px] p-[16px] w-full border-[#DDE0E8]" type="text" name="residentName" placeholder="Введите название" required>
        <div class="grid grid-cols-2 gap-6 justify-between my-[4%]">
            <div class="flex flex-col">
                <label class="text-[#9DA5B0] text-[16px] font-[400]" for="door">Номер</label>
                <input class="w-full rounded-[12px] p-[16px] border border-[1px] border-[#DDE0E8]" type="text" name="door" placeholder="Введите номер" required>
            </div>
            <div class="flex flex-col">
                <label class="text-[#9DA5B0] text-[16px] font-[400]" for="floor">Этаж</label>
                <input class="w-full rounded-[12px] p-[16px] border border-[1px] border-[#DDE0E8]" type="text" name="floor" placeholder="Введите этаж" required>
            </div>
        </div>
        <label class="text-[#9DA5B0] text-[16px] font-[400]" for="email">Электронная почта организации</label>
        <input class="w-full rounded-[12px] p-[16px] border border-[1px] border-[#DDE0E8]" type="email" name="email" placeholder="Email" required>
        <button type="submit" class="bg-blue-500 w-full rounded-[12px] text-white py-[16px] font-[400] text-[18px] mt-[4%]">Создать резидента</button>
    </form>
</div>