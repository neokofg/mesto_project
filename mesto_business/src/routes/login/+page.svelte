<script>
    import Input from '../../components/input.svelte';
    import Toast from '../../components/toast.svelte';
    import {goto} from "$app/navigation";

    let password = '';
    let login = '';
    let toastMessage = '';
    let showToast = false;

    function triggerToast() {
        toastMessage = 'Неверный логин или пароль';
        showToast = true;
        setTimeout(() => showToast = false, 3000); // Автоматически скрывать тост через 3 секунды
    }
    const apiUrl = import.meta.env.VITE_API_URL;

    $: isFormFilled = password && login;
    $: buttonClass = isFormFilled
        ? 'py-[16px] mt-[4%] w-full transition-all text-[18px] font-[400] text-white rounded-[12px] bg-blue-500'
        : 'py-[16px] mt-[4%] w-full transition-all text-[18px] font-[400] text-[#9DA5B0] rounded-[12px] bg-[#F1F5F9]';
    $: buttonText = isFormFilled ? 'Продолжить' : 'Зарегистрироваться';

    async function handleSubmit(event) {
        event.preventDefault();
        let data = {
            login: login,
            password: password,
        }
        isFormFilled = false;
        const response = await fetch(apiUrl + "/auth/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        if (!response.ok) {
            triggerToast();
            isFormFilled = true;
        } else {
            try {
                const responseData = await response.json(); // Получаем JSON из ответа
                let token = responseData.token; // Извлекаем токен из JSON
                localStorage.setItem("token", token); // Сохраняем токен в localStorage
                goto('/app');
            } catch (error) {
                console.error('Ошибка при обработке JSON:', error);
            }
        }
    }
    function register() {
        goto('/register')
    }
</script>
<Toast color="red" message={toastMessage} show={showToast}/>
<div class="grid grid-cols-1 lg:grid-cols-2 grid-rows-1" style="height: 100vh">
    <div class="flex items-center bg-white">
        <div class="mx-auto max-w-[619px]">
            <div class="text-center">
                <img class="mx-auto" src="https://cdn.360mesto.ru/business/logo.png" width="121" height="22" alt="mesto">
                <h1 class="text-[32px] font-[600]">Регистрация в личном кабинете</h1>
                <h2 class="text-[18px] font-[400] text-[#64748B]">Для регистрации заполните форму ниже</h2>
            </div>
            <div>
                <form on:submit={handleSubmit}>
                    <Input bind:value={login} label="Логин" name="login" type="text" placeholder="Введите логин" />
                    <Input bind:value={password} label="Пароль" name="password" type="password" placeholder="Введите пароль" />
                    <button disabled={!isFormFilled} class={buttonClass} type="submit">{buttonText}</button>
                </form>
                <p class="text-[18px] font-[400] text-center mt-[4%]">Еще нет аккаунта? <span on:click={register} class="hover:underline cursor-pointer text-blue-500 font-[600]">Зарегестрироваться</span></p>
            </div>
        </div>
    </div>
    <div class="bg-[#E2E8F0] h-full relative">

    </div>
</div>