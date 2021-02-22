<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div class="flex flex-row items-center">
                <jet-application-logo class="block h-20 w-auto" />
                <span class="ml-4 text-6xl font-bold">Pigvelop</span>
                <span class="ml-4 text-6xl font-semibold">To Do</span>
            </div>

            <div class="mt-8 text-2xl">
                Welcome to your To Do List application!
            </div>

            <div class="mt-6 text-gray-500">
                Pigvelop To Do helps you create your To Do lists in simple way, powerful, and enjoyable. You can create Lists, add items and sub-items,
                drag and drop sub-items to any item or drag a sub-item to New To Do Item area to promote then to a item.
                You can share your lists to other users by e-mail. If you delete a list you can recover then by using Filter Recycle Bin.
            </div>
        </div>
    </div>
</template>

<script>
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo'

    export default {
        components: {
            JetApplicationLogo,
        },
    }
</script>
