<script>
  import "../app.pcss";
  import {redirect} from "@sveltejs/kit";
  redirect(307,'/register')
</script>
<slot />
