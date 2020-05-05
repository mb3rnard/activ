<script>
    import axios from 'axios'

    export default {
        name: "activityRecord",
        props: {
            date: '',
            activity: '',
            recorded: false
        },
        methods: {
            toggle() {
                const payload =  Object.assign({}, {'activity_id': this.activity, 'date': this.date})

                if (this.recorded === false) {
                    axios.post('/activities/record', payload).then(response => {
                        console.log(response);
                    });
                } else {
                    axios.delete('/recorded-activities/delete/' + this.activity + '/' + this.date).then(response => {
                        console.log(response);
                    });
                }
                // else delete record

                this.recorded = !this.recorded;
                console.log(this.recorded);
            }
        },
    }
</script>

<template>
    <input type="checkbox" :checked="recorded" v-on:click="toggle()">
</template>
