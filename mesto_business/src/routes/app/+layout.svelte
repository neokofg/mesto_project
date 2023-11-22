<script>
    import Header from "../../components/header.svelte";
    import {goto} from "$app/navigation";
    let savedToken = localStorage.getItem("token");
    if(savedToken == null) {
        goto('/register')
    }
</script>
<Header />
<slot />