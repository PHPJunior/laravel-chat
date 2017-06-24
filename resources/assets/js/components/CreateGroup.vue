<template>
    <div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">Create Group</h3>
            <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <form role="form">
            <div class="box-body">
                <div class="form-group">
                    <input class="form-control" type="text" v-model="name" placeholder="Group Name">
                </div>
                <div class="form-group">
                    <select class="form-control" v-model="users" multiple id="friends">
                        <option v-for="user in initialUsers" :value="user.id">
                            {{ user.name }}
                        </option>
                    </select>
                </div>
                <button type="submit" @click.prevent="createGroup" class="btn btn-primary">Create Group</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['initialUsers' , 'currentUser'],

        data() {
            return {
                name: '',
                users: []
            }
        },

        methods: {
            createGroup() {
                axios.post('/groups', {name: this.name, users: this.users, user_id: this.currentUser.id})
                .then((response) => {
                    this.name = '';
                    this.users = [];
                    Bus.$emit('groupCreated', response.data);
                });
            }
        }
    }
</script>
