<script>
    import Input from '../../../components/input.svelte';
    import {goto} from "$app/navigation";
    import Toast from "../../../components/toast.svelte";
    let name = null;
    let email = null;
    let toastMessage = '';
    let showToast = false;
    let token = '';
    let color = '';
    let isFilled = false;
    $: isFilled = name || email;
    const apiUrl = import.meta.env.VITE_API_URL;
    if(typeof window !== 'undefined') {
        $: token = localStorage.getItem('token');
    }
    function triggerToast() {
        toastMessage = 'Произошла ошибка';
        color = "red";
        showToast = true;
        setTimeout(() => showToast = false, 3000); // Автоматически скрывать тост через 3 секунды
    }
    function triggerToastOk() {
        toastMessage = 'Успешно';
        color = "green";
        showToast = true;
        setTimeout(() => showToast = false, 3000); // Автоматически скрывать тост через 3 секунды
    }
    async function submit(event) {
        event.preventDefault()
        let data = {
            name: name,
            email: email,
        }
        isFilled = true;
        const response = await fetch(apiUrl + "/user/", {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
            body: JSON.stringify(data)
        })
        if (response.ok) {
            triggerToastOk();
            isFilled = false;
        } else {
            triggerToast();
            isFilled = false;
        }
    }

    function back() {
        goto("/app")
    }

    async function logout() {
        localStorage.removeItem('token');
        goto('/register');
    }
</script>
<Toast color={color} message={toastMessage} show={showToast}/>
<div class="container flex items-center bg-white p-[32px] w-full mx-auto rounded-[20px]">
    <img on:click={back} class="hover:opacity-[0.8] transition-all cursor-pointer" src="https://cdn.360mesto.ru/landing/backbutton.png" alt="">
    <h2 class="text-[32px] font-[600] text-[#020617] ml-[2%]">Личный кабинет</h2>
</div>
<div class="container flex bg-white rounded-[20px] mx-auto w-full mt-[1%] pt-[100px] pl-[100px] pb-[10%] ">
    <div class="text-[18px] font-[400]">
        <p class="text-[#235DFF]">Личные данные</p>
        <p class="text-[#92979F] mt-[20%]">Настройки</p>
        <p on:click={logout} class="cursor-pointer text-[#F53B12] mt-[20%]">Выйти из профиля</p>
    </div>
    <div class="ml-[20%] w-[40%]">
        <form on:submit={submit}>
            <div class="flex justify-between">
                <div class="flex flex-col mt-[4%]">
                    <label class="text-[#09090B] font-[400] text-[16px] mb-[1%]" for="{name}">Название организации</label>
                    <input bind:value={name} class="hover:border-[#a2a4aa] focus:outline-none focus:border-[#235DFF] transition-all border border-[1px] border-[#DDE0E8] rounded-[12px] p-[16px] font-[400] text-[18px]" type="text" placeholder="Введите название">
                </div>
                <div class="flex flex-col mt-[4%]">
                    <label class="text-[#09090B] font-[400] text-[16px] mb-[1%]" for="{email}">Почта</label>
                    <input bind:value={email} class="hover:border-[#a2a4aa] focus:outline-none focus:border-[#235DFF] transition-all border border-[1px] border-[#DDE0E8] rounded-[12px] p-[16px] font-[400] text-[18px]" type="text" placeholder="Введите почту">
                </div>
            </div>
            <button disabled={!isFilled} class="mt-[10%] py-[16px] px-[32px] bg-[#235DFF] text-[#FFFFFF] rounded-[12px] disabled:text-[#92979F] text-[18px] font-[400] disabled:bg-[#F1F5F9]">Сохранить изменения</button>
        </form>
    </div>
</div>