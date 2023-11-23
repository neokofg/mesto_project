<script>
    let format = '';
    function next() {
        console.log("ho")
        format.classList.add('hidden');
    } // не работает
</script>
<div class="flex container bg-white p-[32px] w-full mx-auto rounded-[20px]">
    <img src="https://cdn.360mesto.ru/landing/backbutton.png" alt="">
    <h2 class="text-[32px] font-[600] text-[#020617] ml-[2%]">IT Park Yakutia</h2>
</div>
<div bind:this={format} class="container w-[50%] bg-white rounded-[20px] mx-auto p-[24px] mt-[5%]">
    <h2 class="text-[24px] font-[600] text-[#020617]">Выберите ваш формат</h2>
    <p class="text-[18px] font-[400] text-[#92979F]">Где вы учитесь или работаете?</p>
    <div class="grid grid-cols-3 gap-3 h-[180px] mt-[5%]">
        <div class="relative flex flex-col w-full h-full border border-[#235DFF] rounded-[24px]">
            <img class="absolute right-2 top-2" src="https://cdn.360mesto.ru/landing/CheckBox.png" alt="">
            <img class="mx-auto mt-auto mb-[10%]" src="https://cdn.360mesto.ru/landing/School.png" alt="">
            <p class="text-[20px] font-[600] text-[#020617] text-center mb-auto">Школы</p>
        </div>
        <div class="relative flex flex-col w-full h-full border border-[#DDE0E8] rounded-[24px]">
            <img class="absolute right-2 top-2" src="https://cdn.360mesto.ru/landing/CheckBoxUF.png" alt="">
            <img class="mx-auto mt-auto mb-[10%]" src="https://cdn.360mesto.ru/landing/University.png" alt="">
            <p class="text-[20px] font-[600] text-[#020617] text-center mb-auto">Высшие учебные заведения</p>
        </div>
        <div class="relative flex flex-col w-full h-full border border-[#DDE0E8] rounded-[24px]">
            <img class="absolute right-2 top-2" src="https://cdn.360mesto.ru/landing/CheckBoxUF.png" alt="">
            <img class="mx-auto mt-auto mb-[10%]" src="https://cdn.360mesto.ru/landing/Wave.png" alt="">
            <p class="text-[20px] font-[600] text-[#020617] text-center mb-auto">Индивидуальный участник</p>
        </div>
    </div>
    <div class="grid grid-cols-3 items-center mt-[5%]">
        <div></div>
        <h2 class="text-[24px] font-[600] text-center">1/5</h2>
        <button on:click={next} class="py-[16px] px-[32px] rounded-[12px] bg-[#235DFF] max-w-[115px] ml-auto text-white text-[18px] font-[400]">Далее</button>
    </div>
</div>