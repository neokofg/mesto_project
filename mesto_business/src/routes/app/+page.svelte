<script>
    import {goto} from "$app/navigation";

    async function createResidentKey() {
        goto('/newResident')
    }
</script>
<div class="grid gap-6 grid-cols-3 grid-rows-1 container mx-auto">
    <div class="col-span-2 h-[70vh] bg-white rounded-[20px] p-[20px]">
        <h1 class="text-[24px] font-[600]">Резиденты 1</h1>
        <div class="mt-[24px]">
            <div class="flex justify-between border border-[1px] border-[#DDE0E8] rounded-[16px] p-[16px]">
                <div>
                    <div class="flex items-center justify-center bg-[#F1F5F9] w-[192px] h-[38px] rounded-[12px]">
                        <p class="text-[16px] font-[500] text-[#9DA5B0]">F48s-0HeQ-Tka9-J2e4</p>
                    </div>
                    <h2 class="text-[20px] font-[500]">ООО “Сайберия”</h2>
                </div>
                <img width="56" style="aspect-ratio: 1; height: 56px;" height="56" class="mt-auto" src="https://cdn.360mesto.ru/business/arrow.png" alt="->">
            </div>
        </div>
    </div>
    <div class="flex flex-col bg-white rounded-[20px] p-[20px] h-[20vh]">
        <h2 class="text-[24px] font-[600]">Генерация ключ-кода</h2>
        <button on:click={createResidentKey} class="hover:opacity-[0.8] hover:outline-none transition-all w-full mt-auto bg-blue-500 rounded-[12px] text-[18px] text-[400] text-white py-[16px] mt-auto">Сгенерировать ключ-ссылку</button>
    </div>
</div>