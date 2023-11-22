<script>
    export let name,type,placeholder,label, value;
</script>
<div class="flex flex-col mt-[4%]">
    <label class="text-[#09090B] font-[400] text-[16px] mb-[1%]" for="{name}">{label}</label>
    {#if type === 'text'}
        <input bind:value={value} class="hover:border-[#a2a4aa] focus:outline-none focus:border-[#235DFF] transition-all border border-[1px] border-[#DDE0E8] rounded-[12px] p-[16px] font-[400] text-[18px]" type="text" placeholder="{placeholder}" required>
    {:else if type === 'password'}
        <input bind:value={value} class="hover:border-[#a2a4aa] focus:outline-none focus:border-[#235DFF] transition-all border border-[1px] border-[#DDE0E8] rounded-[12px] p-[16px] font-[400] text-[18px]" type="password" placeholder="{placeholder}" required>
    {/if}
</div>