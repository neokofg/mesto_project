<script>
    import Header from "../../components/header.svelte";
    import Footer from "../../components/footer.svelte";
    import {goto} from "$app/navigation";
    let savedToken = '';
    if(typeof window !== 'undefined') {
        $: savedToken = localStorage.getItem('token');
    }
    if(savedToken == null) {
        goto('/register')
    }
</script>
<Header />
<slot />
<Footer />