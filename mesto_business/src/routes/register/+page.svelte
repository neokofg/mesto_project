<script>
    import Input from '../../components/input.svelte';
    import {goto} from "$app/navigation";
    let organization = '';
    let email = '';
    let password = '';
    let confirmPassword = '';
    let passwordsMatch = false;
    const apiUrl = import.meta.env.VITE_API_URL;

    $: passwordsMatch = password === confirmPassword;
    $: isFormFilled = organization && email && password && confirmPassword;
    $: buttonClass = isFormFilled
        ? 'py-[16px] w-full mt-[5%] text-[18px] font-[400] text-white rounded-[12px] bg-blue-500'
        : 'py-[16px] w-full mt-[5%] text-[18px] font-[400] text-[#9DA5B0] rounded-[12px] bg-[#F1F5F9]';
    $: buttonText = isFormFilled ? 'Продолжить' : 'Зарегистрироваться';

    async function handleSubmit(event) {
        event.preventDefault();
        let data = {
            email: email,
            password: password,
            organization_name: organization
        }
        const response = await fetch(apiUrl + "/auth/register", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        if (!response.ok) {
            alert(`Ошибка: ${response}`);
        } else {
            goto('/register/email')
        }
    }
</script>
<div class="grid grid-cols-2 grid-rows-1" style="height: 100vh">
    <div class="relative bg-white">
        <div class="absolute top-40 left-1/4">
            <div class="text-center">
                <img class="mx-auto" src="logo.png" width="121" height="22" alt="mesto">
                <h1 class="text-[32px] font-[600]">Регистрация в личном кабинете</h1>
                <h2 class="text-[18px] font-[400] text-[#64748B]">Для регистрации заполните форму ниже</h2>
            </div>
            <div>
                <form on:submit={handleSubmit}>
                    <Input bind:value={organization} label="Название организации" name="organization" type="text" placeholder="Введите" />
                    <Input bind:value={email} label="Адрес электронной почты" name="email" type="text" placeholder="Введите вашу почту" />
                    <Input bind:value={password} label="Пароль" name="password" type="password" placeholder="Введите пароль" />
                    <Input bind:value={confirmPassword} label="Подтверждение пароля" name="confirmPassword" type="password" placeholder="Повторно введите пароль" />
                    {#if password && confirmPassword && !passwordsMatch}
                        <div style="color:red" class="text-left mt-[5%]">Пароли не совпадают!</div>
                    {/if}
                    <button disabled={!isFormFilled} class={buttonClass} type="submit">{buttonText}</button>
                </form>
            </div>
        </div>
    </div>
    <div class="bg-[#E2E8F0] h-full relative">

    </div>
</div>