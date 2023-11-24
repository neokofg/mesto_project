<script>
    import {onMount} from "svelte";

    let file = '';
    let token = '';
    let user = [];
    const panorama_url = import.meta.env.VITE_PANORAMA_URL
    const apiUrl = import.meta.env.VITE_API_URL
    if(typeof window !== 'undefined') {
        $: token = localStorage.getItem('token');
    }
    async function upload() {
        let formData = new FormData()
        formData.append("file", file);
        formData.append("rezident", user.name)
        let response = await fetch(panorama_url + "/api/upload", {
            method: "POST",
            headers: {
                "Content-Type": "multipart/form-data",
            },
            body: formData
        })
    }

    onMount(async () => {
        let response = await fetch(apiUrl + '/user/', {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
        })
        response = await response.json()
        $: user = response.user
    });
</script>
<div class="flex-col mx-auto max-w-[619px] bg-white rounded-[20px] flex p-[20px]">
    <h1 class="text-[24px] font-[600] text-[#020617]">{user.name}</h1>
    <h2 class="text-[32px] text-center font-[600] text-[#020617] mt-[4%]">Загрузите фото панораму для 360</h2>
    <form on:submit={upload} class="mt-[5%]">
        <label for="file-upload" class="custom-file-upload">
            <i class="fas fa-cloud-upload-alt"></i> Загрузите файл
        </label>
        <input bind:value={file} id="file-upload" type="file" style="display: none;"/>
        <button class="mt-[5%] w-full py-[16px] px-[32px] rounded-[12px] bg-[#235DFF] text-white">Загрузить</button>
    </form>
</div>