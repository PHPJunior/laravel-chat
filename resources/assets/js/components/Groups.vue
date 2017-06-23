<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Group Lists</h3>
                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="" v-for="group in groups" :key="group.id">
                                <a :href="'#'+group.id"  data-toggle="tab">{{ group.name }}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-8">
                <div class="tab-content">
                    <div class="tab-pane" :id="group.id" v-for="group in groups" :key="group.id">
                        <group-chat :current_user="user" :users="group.users" :group="group">
                        </group-chat>
                    </div>
                    <!-- /.tab-pane -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['initialGroups', 'user'],

        data() {
            return {
                groups: []
            }
        },

        mounted() {
            this.groups = this.initialGroups;

            Bus.$on('groupCreated', (group) => {
                this.groups.push(group);
            });

            this.listenForNewGroups();
        },

        methods: {
            listenForNewGroups() {
                Echo.private('users.' + this.user.id)
                    .listen('\\PhpJunior\\LaravelChat\\Events\\GroupCreated', (e) => {
                        this.groups.push(e.group);
                    });
            }
        }
    }
</script>
