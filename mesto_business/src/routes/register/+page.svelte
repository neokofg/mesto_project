<script>
    import Input from '../../components/input.svelte';
    import Toast from '../../components/toast.svelte';
    import {goto} from "$app/navigation";
    import {onMount} from "svelte";
    let organization = '';
    let email = '';
    let password = '';
    let confirmPassword = '';
    let passwordsMatch = false;
    let toastMessage = '';
    let showToast = false;

    function triggerToast() {
        toastMessage = 'Произошла ошибка';
        showToast = true;
        setTimeout(() => showToast = false, 3000); // Автоматически скрывать тост через 3 секунды
    }

    const apiUrl = import.meta.env.VITE_API_URL;

    $: passwordsMatch = password === confirmPassword;
    $: isFormFilled = organization && email && password && confirmPassword && passwordsMatch;
    $: buttonClass = isFormFilled
        ? 'py-[16px] w-full transition-all text-[18px] font-[400] text-white rounded-[12px] bg-blue-500'
        : 'py-[16px] w-full transition-all text-[18px] font-[400] text-[#9DA5B0] rounded-[12px] bg-[#F1F5F9]';
    $: buttonText = isFormFilled ? 'Продолжить' : 'Зарегистрироваться';

    async function handleSubmit(event) {
        event.preventDefault();
        let data = {
            email: email,
            password: password,
            organization_name: organization
        }
        isFormFilled = false;
        const response = await fetch(apiUrl + "/auth/register", {
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
            goto('/register/email')
        }
    }

    onMount(() => function() {
        let savedToken = localStorage.getItem("token");
        if(savedToken != null) {
            goto('/app')
        }
    })
</script>
<Toast message={toastMessage} show={showToast}/>
<div class="grid grid-cols-2 grid-rows-1" style="height: 100vh">
    <div class="relative bg-white">
        <div class="absolute top-40 left-1/4">
            <div class="text-center">
                <img class="mx-auto" src="https://cdn.360mesto.ru/business/logo.png" width="121" height="22" alt="mesto">
                <h1 class="text-[32px] font-[600]">Регистрация в личном кабинете</h1>
                <h2 class="text-[18px] font-[400] text-[#64748B]">Для регистрации заполните форму ниже</h2>
            </div>
            <div>
                <form on:submit={handleSubmit}>
                    <Input bind:value={organization} label="Название организации" name="organization" type="text" placeholder="Введите" />
                    <Input bind:value={email} label="Адрес электронной почты" name="email" type="text" placeholder="Введите вашу почту" />
                    <Input bind:value={password} label="Пароль" name="password" type="password" placeholder="Введите пароль" />
                    <Input bind:value={confirmPassword} label="Подтверждение пароля" name="confirmPassword" type="password" placeholder="Повторно введите пароль" />
                    <div class="text-red-500 text-left my-[5%] transition-all {password && confirmPassword && !passwordsMatch ? 'slide-down show' : 'slide-down'}">Пароли не совпадают!</div>
                    <button disabled={!isFormFilled} class={buttonClass} type="submit">{buttonText}</button>
                </form>
            </div>
        </div>
    </div>
    <div class="bg-[#E2E8F0] h-full relative">

    </div>
</div>