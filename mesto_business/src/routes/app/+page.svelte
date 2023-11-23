<script>
    import {goto} from "$app/navigation";
    const apiUrl = import.meta.env.VITE_API_URL;
    let combinedArray = [];
    let token = '';
    let loading = true;
    async function createResidentKey() {
        goto('/newResident')
    }
    if(typeof window !== 'undefined') {
        $: token = localStorage.getItem('token');
    }
    function fetchInvitations() {
        return fetch(apiUrl + '/residents/invitations', {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
        }).then(response => response.json())
            .then(data => data.residents);
    }

    function fetchResidents() {
        return fetch(apiUrl + '/residents/', {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
        }).then(response => response.json())
            .then(data => data.residents);
    }
    function combineData(invitations, residents) {
        const combined = [];
        invitations.forEach(invitation => {
            combined.push({ hash: invitation.hash || null, name: invitation.name });
        });
        residents.forEach(resident => {
            combined.push({ hash: null, name: resident.name });
        });

        return combined;
    }

    Promise.all([fetchInvitations(), fetchResidents()])
        .then(([invitations, residents]) => {
            $: combinedArray = combineData(invitations, residents);
            $: loading = false;
        })
        .catch(error => {
            console.error('Ошибка при получении данных:', error);
        });
</script>
<div class="grid gap-6 grid-cols-3 grid-rows-1 container mx-auto">
    <div class="col-span-2 h-[70vh] bg-white rounded-[20px] p-[20px]">
        <h1 class="text-[24px] font-[600]">Резиденты {combinedArray.length}</h1>
        {#if loading}
            <div class="flex items-center h-full">
                <img class="mx-auto mb-[10%]" src="https://cdn.360mesto.ru/business/spinner.gif" alt="Loading...">
            </div>
        {/if}
        {#each combinedArray as item}
            <div class="mt-[24px]">
                <div class="flex justify-between border border-[1px] border-[#DDE0E8] rounded-[16px] p-[16px]">
                    <div>
                        {#if item.hash}
                            <div class="flex items-center justify-center bg-[#F1F5F9] w-[192px] h-[38px] rounded-[12px]">
                                <p class="text-[16px] font-[500] text-[#9DA5B0]">{item.hash}</p>
                            </div>
                        {/if}
                        <h2 class="text-[20px] font-[500]">{item.name}</h2>
                    </div>
                    <a href=""><img width="56" style="aspect-ratio: 1; height: 56px;" height="56" class="mt-auto cursor-pointer hover:opacity-[0.5] hover:border-[2px] border-[#000] transition-all rounded-[60px]" src="https://cdn.360mesto.ru/business/arrow.png" alt="->"></a>
                </div>
            </div>
        {/each}
    </div>
    <div class="flex flex-col bg-white rounded-[20px] p-[20px] h-[20vh]">
        <h2 class="text-[24px] font-[600]">Генерация ключ-кода</h2>
        <button on:click={createResidentKey} class="hover:opacity-[0.8] hover:outline-none transition-all w-full mt-auto bg-blue-500 rounded-[12px] text-[18px] text-[400] text-white py-[16px] mt-auto">Сгенерировать ключ-ссылку</button>
    </div>
</div>