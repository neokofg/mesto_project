<script>
    import Header from "../../components/headerResident.svelte";
    import Footer from "../../components/footer.svelte";
    import {goto} from "$app/navigation";
    // import {onMount} from "svelte";
    // onMount(() => function() {
    //     let savedToken = localStorage.getItem("token");
    //     if(savedToken == null) {
    //         goto('/register')
    //     }
    // })
</script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
<Header />
<slot />
<Footer />