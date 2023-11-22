<script>
    import Header from "../../components/header.svelte";
    import {goto} from "$app/navigation";
    import {onMount} from "svelte";
    onMount(() => function() {
        let savedToken = localStorage.getItem("token");
        if(savedToken == null) {
            goto('/register')
        }
    })
</script>
<Header />
<slot />