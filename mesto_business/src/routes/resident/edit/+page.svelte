<script>
    import Quit from '../../../components/quit.svelte'
    import Toast from "../../../components/toast.svelte";
    let toastMessage = '';
    let showToast = false;
    let color = "";
    function triggerToast() {
        toastMessage = 'Успешно обновлено!';
        showToast = true;
        color = "green";
        setTimeout(() => showToast = false, 3000); // Автоматически скрывать тост через 3 секунды
    }
    function triggerBadToast() {
        toastMessage = 'Произошла ошибка!';
        showToast = true;
        color = "red";
        setTimeout(() => showToast = false, 3000); // Автоматически скрывать тост через 3 секунды
    }
    const apiUrl = import.meta.env.VITE_API_URL;
    let token = '';
    let description = '';
    if(typeof window !== 'undefined') {
        $: token = localStorage.getItem('token');
    }
    console.log(description.value)
    async function submit(event) {
        event.preventDefault()
        let data = {
            description: description.value
        }
        let update = await fetch(apiUrl + "/residents", {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
            body: JSON.stringify(data)
        });
        update = await update.json()
        if(update.status) {
            triggerToast()
        } else {
            triggerBadToast()
        }
    }
</script>
<Toast color={color} message={toastMessage} show={showToast}/>
<div class="flex-col mx-auto max-w-[619px] bg-white rounded-[20px] flex p-[20px]">
    <div class="flex justify-between">
        <h1 class="text-[24px] font-[600] text-[#020617]">ООО "Сайберия"</h1>
        <Quit/>
    </div>
    <form on:submit={submit} class="mt-[5%]">
        <div class="flex flex-col">
            <label class="text-[16px] font-[400] text-[#92979F] mb-[1%]" for="description">Добавьте описание</label>
            <textarea bind:this={description} class="text-[18px] font-[400] p-[16px] rounded-[12px] border border-[#DDE0E8] bg-[#FFFFFF]" name="description" rows="5">Добавьте краткое описание вашей компании и чем вы занимаетесь</textarea>
        </div>
        <button type="submit" class="mt-[5%] w-full py-[16px] px-[32px] rounded-[12px] bg-[#235DFF] text-white">Обновить</button>
    </form>
</div>