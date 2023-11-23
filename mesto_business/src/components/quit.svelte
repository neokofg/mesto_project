<script>
    import {goto} from "$app/navigation";

    let animation;
    async function animate() {
        animation.style.opacity = 1;
        animation.style.width = 1 + "px";
        setTimeout(function() {
            animation.style.width = 100 + "%"
        }, 100)
    }
    async function deanimate() {
        animation.style.opacity = 0;
        animation.style.width = 1 + "px";
    }

    async function logout() {
        localStorage.removeItem('token');
        goto('/register');
    }
</script>
<div on:mouseover={animate} on:mouseleave={deanimate} class="flex flex-col">
    <p on:click={logout} class="hover:opacity-[0.8] cursor-pointer text-[18px] font-[400]">Выйти</p>
    <div bind:this={animation} class="opacity-0 w-[1px] transition-all bg-black h-[1px] w-full"></div>
</div>