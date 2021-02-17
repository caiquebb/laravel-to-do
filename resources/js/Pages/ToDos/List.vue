<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My To Do Lists
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <todo-card :key="todo.id" v-for="todo in todos" :todo="todo"></todo-card>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout';
    import Button from '@/Jetstream/Button';
    import TodoCard from './Card';

    export default {
        components: {
            AppLayout,
            Button,
            TodoCard,
        },

        data: function() {
            return {
                todos: [
                    {
                        id: 1,
                        description: 'To Do 1',
                        slug: 'to-do-1'
                    },
                    {
                        id: 2,
                        description: 'To Do 2',
                        slug: 'to-do-2'
                    },
                    {
                        id: 3,
                        description: 'To Do 3',
                        slug: 'to-do-3'
                    },
                    {
                        id: 4,
                        description: 'To Do 4',
                        slug: 'to-do-4'
                    },
                ]
            }
        }
    }
</script>
