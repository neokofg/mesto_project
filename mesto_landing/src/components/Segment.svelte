<script>
    export let segment,heading,text,logo;
</script>
<div class="bg-white rounded-[32px] p-[24px] mt-[20%] mb-[35%]">
    <div class="flex items-center">
        <img width="56" height="56" src="{logo}" alt="">
        <p class="text-[18px] font-[400] text-[#92979F] ml-[5%]">Сегмент {segment}</p>
    </div>
    <h2 class="mt-[4%] w-2/3 text-[32px] font-[600] text-[#020617]">{heading}</h2>
    <p class="mt-[4%] text-[#92979F] font-[400] text-[18px]">{text}</p>
</div>