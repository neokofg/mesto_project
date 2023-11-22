<script>
    import {goto} from "$app/navigation";
    import {redirect} from "@sveltejs/kit";

    let pins = ['', '', '', ''];

    function focusNext(index, event) {
        if (event.target.value.length > 0 && index < pins.length - 1) {
            document.getElementById(`pin-${index + 1}`).focus();
        }
    }

    function focusPrevious(index, event) {
        if (event.key === 'Backspace' && pins[index].length === 0 && index > 0) {
            document.getElementById(`pin-${index - 1}`).focus();
        }
    }
    $: isFormFilled = pins.every(pin => pin.trim() !== '');
    $: buttonClass = isFormFilled
        ? 'py-[16px] px-[80px] bg-blue-500 text-white rounded-[12px] mt-[10%]'
        : 'py-[16px] px-[80px] bg-[#F1F5F9] text-[#9DA5B0] rounded-[12px] mt-[10%]';
    $: buttonText = isFormFilled ? 'Продолжить' : 'Зарегистрироваться';

    async function handleSubmit(event) {
        event.preventDefault();
        goto('../app')
    }
</script>
<div class="grid grid-cols-2 grid-rows-1" style="height: 100vh">
    <div class="relative bg-white">
        <div class="absolute top-1/3 left-1/3">
            <div class="flex flex-col text-center w-2/3">
                <img src="../mail.png" class="mx-auto" width="40" height="40" alt="">
                <h1 class="text-[24px] font-[600] mt-[10%]">Подтвердите E-mail</h1>
                <p class="text-[18px] font-[400] text-[#9DA5B0] mt-[10%]">Мы направили проверочный  код на: <span class="text-[#020617]">immaxdesign@gmail.com</span></p>
                <form on:submit={handleSubmit}>
                    <div class="pincode-input-container mt-[10%]    ">
                        {#each pins as pin, index (index)}
                            <input
                                    id="pin-{index}"
                                    class="pincode-input"
                                    type="text"
                                    maxlength="1"
                                    bind:value={pins[index]}
                                    on:input={event => focusNext(index, event)}
                                    on:keydown={event => focusPrevious(index, event)}
                                    placeholder="•"
                            />
                        {/each}
                    </div>
                    <button disabled={!isFormFilled} class={buttonClass} type="submit">Подтвердить</button>
                </form>
            </div>
        </div>
    </div>
    <div class="bg-[#E2E8F0] h-full relative">

    </div>
</div>