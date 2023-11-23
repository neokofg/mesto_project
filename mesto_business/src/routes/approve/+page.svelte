<script>
    import { page } from '$app/stores';
    import {goto} from "$app/navigation";
    let key = $page.url.searchParams.get('key');
    let isDisabled = false;
    const apiUrl = import.meta.env.VITE_API_URL;
    async function approve() {
        isDisabled = true;
        let approve = await fetch(apiUrl + "/approve_key/" + key, {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            },
        })
        approve = await approve.json()
        localStorage.setItem('token',approve.credentials.token)
        goto('/resident')
    }

    async function decline() {
        isDisabled = true;
        let decline = await fetch(apiUrl + "/decline_key/" + key, {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            },
        })
        decline = await decline.json()
        goto('/register')
    }
</script>
<div class="flex-col mx-auto max-w-[619px] bg-white rounded-[20px] flex p-[20px]">
    <h1 class="text-[24px] font-[600] text-[#020617]">ООО "Сайберия"</h1>
    <p class="text-[18px] font-[400] text-center mt-[5%]">Вас пригласили в огранизацию: <span class="font-[600]">ITPark</span></p>
    <form class="flex justify-between mt-[5%]">
        <button on:click={approve} disabled={isDisabled} class="disabled:opacity-[0.5] w-[45%] py-[16px] px-[32px] rounded-[12px] bg-[#235DFF] text-white">Принять</button>
        <button on:click={decline} disabled={isDisabled} class="disabled:opacity-[0.5] w-[45%] py-[16px] px-[32px] rounded-[12px] bg-[#E5ECFF] text-[#235DFF]">Отклонить</button>
    </form>
</div>