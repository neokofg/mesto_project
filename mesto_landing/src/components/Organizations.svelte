<script>
    export let organizations;
</script>
<div class="container flex bg-white p-[32px] w-full mx-auto rounded-[20px]">
    <a href="/"><img src="https://cdn.360mesto.ru/landing/backbutton.png" alt=""></a>
    <h2 class="text-[32px] font-[600] text-[#020617] ml-[2%]">Места для экскурсии</h2>
</div>

{#each organizations as item}
    <div class="container flex bg-white rounded-[20px] mx-auto w-full p-[20px] mt-[1%]">
        <a href={import.meta.env.PUBLIC_PANORAMA_URL}><img src="https://cdn.360mesto.ru/landing/ITpark.png" alt=""></a>
        <div class="ml-[4%]">
            <h2 class="text-[44px] font-[700]">{item.name}</h2>
            <p class="flex text-[18px] font-[400] mt-[4%] text-[#414751]"><span><img src="https://cdn.360mesto.ru/landing/Location.png" alt=""></span>г. Якутск, ул. Ленина 1,</p>
            <a href="newBooking?id={item.id}&name={item.name}"><button class="bg-[#235DFF] rounded-[16px] mt-[5%] py-[16px] px-[32px] text-white text-[18px] font-[400]">Подать заявку</button></a>
        </div>
    </div>
{/each}