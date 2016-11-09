<template>
    <div class="greeting">
       {{ message }}
    </div>
</template>

<script>
    export default {
        name: 'Greeting',
        data: () => {
            return {
                message: 'This is greeting component'
            }
        }
    }
</script>
