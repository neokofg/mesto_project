<script>
    export let message = '';
    export let show = false;

    export let color = '';

    // Функция для закрытия тоста
    function closeToast() {
        show = false;
    }

    $: toastClass = color === 'red'
        ? 'toast colors-red'
        : 'toast colors-green';
</script>

{#if show}
    <div class="{toastClass}" on:click={closeToast}>
        {message}
    </div>
{/if}

<style>
    .toast {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(100%);
        padding: 10px 40px;
        border-radius: 5px;
        cursor: pointer;
        animation: slide-up 0.3s ease-out;
        z-index: 999;
    }
    .colors-red {
        background-color: darkred;
        color: white;
    }

    .colors-green {
        background-color: darkgreen;
        color: white;
    }

    @keyframes slide-up {
        from {
            transform: translateY(-100%) translateX(-50%);
        }
        to {
            transform: translateY(100%) translateX(-50%);
        }
    }
</style>