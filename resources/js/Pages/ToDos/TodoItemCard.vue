<template>
    <div>
        <jet-processing v-if="form.processing" />

        <div class="border-t border-gray-200 border-dashed flex flex-col p-2 px-4">
            <div :key="key" v-for="(item, key) in todoItems" :class="[key % 2 ? 'bg-gray-200' : 'bg-white', 'py-1']" @drop="dropTodoSubItem($event, item.id)" @dragover.prevent @dragenter.prevent>
                <div class="p-1 flex flex-row space-x-2 items-center">
                    <label class="flex w-full items-center">
                        <jet-checkbox v-model="item.completed" @change="updateTodoItem(item.id, item.completed)"></jet-checkbox>
                        <span :class="[item.completed ? 'line-through' : '', 'ml-2 text-sm w-full']">{{ item.description }}</span>
                    </label>

                    <template v-if="! item.completed">
                        <button v-if="addingTodoSubItem === key" @click="cancelTodoSubItem">
                            <jet-svg-icon icon="x" size="sm" />
                        </button>

                        <button v-else @click="addTodoSubItem(key)">
                            <jet-svg-icon icon="plus" size="sm" />
                        </button>
                    </template>

                    <button @click="deleteTodoItem(item.id)" class="text-red-600">
                        <jet-svg-icon icon="trash" size="sm" />
                    </button>
                </div>

                <div :key="key" v-for="(subItem, key) in item.todo_sub_items" class="p-1 flex flex-row space-x-2 items-center" draggable @dragstart='dragTodoSubItem($event, subItem)'>
                    <jet-svg-icon icon="switchVertical" size="sm"/>
                    <label class="ml-6 flex w-full items-center">
                        <jet-checkbox v-model="subItem.completed" @change="updateTodoItem(subItem.id, subItem.completed)" />
                        <span :class="[subItem.completed ? 'line-through' : '', 'ml-2 text-sm w-full']">
                            {{ subItem.description }}
                        </span>
                    </label>

                    <button @click="deleteTodoItem(subItem.id)" class="text-red-600">
                        <jet-svg-icon icon="trash" size="sm" />
                    </button>
                </div>

                <div v-if="addingTodoSubItem === key" class="flex flex-row items-center ml-6 p-2 border-2 border-gray-500 border-dashed overflow-hidden shadow-xl sm:rounded-lg space-x-2">
                    <div class="flex-1">
                        <jet-input ref="inputTodoSubItemDescription" class="w-full text-sm" type="text" placeholder="Description" v-model="form.description" @keyup.enter.native="createTodoSubItem(item.id)"/>

                        <jet-input-error :message="form.errors.description ? form.errors.description.join(' ') : ''" />
                    </div>
                    <div class="flex-none self-center">
                        <jet-icon-button type="submit" icon='check' size="sm" @click.native="createTodoSubItem(item.id)"></jet-icon-button>
                        <jet-icon-button icon='x' size="sm" variant="secondary" @click.native="cancelTodoSubItem"></jet-icon-button>
                    </div>
                </div>
            </div>
        </div>

        <div @drop="dropTodoSubItem($event, null)" @dragover.prevent @dragenter.prevent>
            <add-todo-item-card :todo="todo" @createdTodoItem="getTodoItems"/>
        </div>
    </div>
</template>

<script>
    import JetCheckbox from '@/Jetstream/Checkbox';
    import AddTodoItemCard from './AddTodoItemCard';
    import JetSvgIcon from '@/Jetstream/SvgIcon';
    import JetInput from '@/Jetstream/Input';
    import JetInputError from '@/Jetstream/InputError';
    import JetIconButton from '@/Jetstream/IconButton';
    import JetProcessing from '@/Jetstream/Processing';

    export default {
        components: {
            JetCheckbox,
            AddTodoItemCard,
            JetSvgIcon,
            JetInput,
            JetInputError,
            JetIconButton,
            JetProcessing,
        },

        props: {
            todo: Object,
        },

        data: function () {
            return {
                todoItems: [],
                addingTodoSubItem: -1,
                form: {
                    processing: false,
                    errors: {},
                    description: '',
                }
            }
        },

        mounted: function() {
            this.getTodoItems();
        },

        methods: {
            getTodoItems: async function() {
                const { id } = this.todo;

                const { data } = await axios.get(`/api/todos/${id}/todo-items`);

                this.todoItems = this.normalizeTodoItems(data);
            },

            normalizeTodoItems(items) {
                return items.filter((item) => {
                    return !item.todo_item_id
                }).map((parent) => {
                    parent.todo_sub_items = items.filter((child) => {
                        return parent.id === child.todo_item_id;
                    });

                    return parent;
                });
            },

            updateTodoItem: async function(id, completed) {
                this.form.processing = true;

                try {
                    await axios.put(`/api/todo-items/${id}`, { completed });
                } catch (error) {
                    console.log(error);
                }

                this.getTodoItems();

                this.form.processing = false;
            },

            dragTodoSubItem: function (event, todoSubItem) {
                event.dataTransfer.dropEffect = 'move'
                event.dataTransfer.effectAllowed = 'move'
                event.dataTransfer.setData('todoSubItemId', todoSubItem.id)
            },

            dropTodoSubItem: async function (event, todoItemId) {
                this.form.processing = true;

                const todoSubItemId = event.dataTransfer.getData('todoSubItemId')

                try {
                    await axios.put(`/api/todo-items/${todoSubItemId}`, { todo_item_id: todoItemId });
                } catch (error) {
                    console.log(error);
                }

                this.getTodoItems();

                this.form.processing = false;
            },

            deleteTodoItem: async function (id) {
                await axios.delete(`/api/todo-items/${id}`);

                this.getTodoItems();
            },

            addTodoSubItem: function (key) {
                this.addingTodoSubItem = key;

                setTimeout(() => {
                    this.$refs.inputTodoSubItemDescription[0].focus()
                }, 250);
            },

            createTodoSubItem: async function (todoItemId) {
                const { id } = this.todo;

                try {
                    await axios.post(`/api/todos/${id}/todo-items`, {
                        ...this.form,
                        todo_item_id: todoItemId,
                    });

                    this.getTodoItems();

                    this.cancelTodoSubItem();
                } catch (error) {
                    console.error(error);

                    if (error.response) {
                         const { status, data } = error.response;

                        if (status === 422) {
                            this.form.errors = data.errors;
                        }
                    }
                }
            },

            cancelTodoSubItem: function () {
                this.addingTodoSubItem = -1;
                this.form.errors = {};
                this.form.description = '';
            }
        },
    }
</script>
