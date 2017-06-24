<template>
    <div>
        <div class="box box-solid direct-chat direct-chat-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ group.name }}</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-widget="chat-pane-toggle" data-original-title="Contacts">
                        <i class="fa fa-users"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages">
                    <!-- Message. Default to the left -->
                    <div class="direct-chat-msg" v-for="conversation in conversations"
                         v-bind:class="{ 'right' : check(conversation.user.id) }">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-left">{{ conversation.user.name }}</span>
                            <span class="direct-chat-timestamp pull-right">
                                <timeago :since="conversation.created_at" :auto-update="10"></timeago>
                            </span>
                        </div>
                        <!-- /.direct-chat-info -->
                        <img class="direct-chat-img"
                             src="https://adminlte.io/themes/AdminLTE/dist/img/user1-128x128.jpg"
                             alt="message user image"><!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                            {{ conversation.message }}
                        </div>
                        <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->

                </div>
                <!--/.direct-chat-messages-->

                <div class="direct-chat-contacts">
                    <ul class="contacts-list">
                        <li v-for="user in users">
                            <a href="javascript:;">
                                <img class="contacts-list-img" src="https://adminlte.io/themes/AdminLTE/dist/img/user1-128x128.jpg" alt="User Image">
                                <div class="contacts-list-info">
                                    <span class="contacts-list-name">
                                        {{ user.name }}
                                    </span>
                                    <span class="contacts-list-msg">
                                        {{ user.email }}
                                    </span>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.contatcts-list -->
                </div>
            </div>
            <div class="box-footer">
                <div class="input-group">
                    <input type="text" v-model="message" @keyup.enter="store()" autofocus name="message"
                           placeholder="Type Message ..." class="form-control">
                    <span class="input-group-btn">
                        <button type="button" @click.prevent="store()" class="btn btn-primary btn-flat">Send</button>
                      </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['group', 'currentUser', 'users'],

        data() {
            return {
                conversations: [],
                message: '',
                group_id: this.group.id
            }
        },

        mounted() {
            this.getCurrentGroupMessage();
            this.listenForNewMessage();
        },

        methods: {
            store() {
                axios.post('/conversations', {
                    message: this.message,
                    group_id: this.group.id,
                    user_id: this.currentUser.id
                })
                    .then((response) => {
                        this.message = '';
                        this.conversations.push(response.data);
                    });
            },

            check(id) {
                return id === this.currentUser.id;
            },

            getCurrentGroupMessage() {
                axios.get('/conversations/' + this.group_id )
                    .then((response) => {
                        this.conversations = response.data ;
                    });
            },

            listenForNewMessage() {
                Echo.private('groups.' + this.group.id)
                    .listen('\\PhpJunior\\LaravelChat\\Events\\NewMessage', (e) => {
                        this.conversations.push(e);
                    });
            }
        }
    }
</script>
