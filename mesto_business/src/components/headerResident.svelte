<script>
    import {goto} from "$app/navigation";
    function redirectApp() {
        goto('/app')
    }
    function redirectProfile() {
        goto('/app/profile')
    }
</script>
<header class="bg-white h-[80px] mb-[40px]">
    <div class="container mx-auto flex items-center justify-between h-full">
        <img on:click={redirectApp} class="cursor-pointer" src="https://cdn.360mesto.ru/business/logo.png" style="height: 22px !important;" width="121" height="22" alt="">
        <button on:click={redirectProfile} class="hover:opacity-[0.8] py-[16px] px-[32px] bg-[#E5ECFF] text-[#235DFF] text-[18px] font-[400] rounded-[12px]">ООО "Сайберия"</button>
    </div>
</header>