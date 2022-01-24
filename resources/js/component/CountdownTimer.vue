<template>
    {{ timeEnd }}
</template>

<script>
import { ref } from "@vue/reactivity";
import axios from "axios";
export default {
    props: ["time"],
    setup(props, { emit }) {
        let time = props.time;
        time = time.split(":");
        time = time[0] * 60 * 60 + time[1] * 60 + time[2] * 1;

        let dispute = ref(null);
        axios
            .get("/get-time")
            .then((response) => {
                dispute.value = response.data.now * 1000 - new Date().getTime();
            })
            .catch((error) => {
                console.log(error);
            });

        const start = new Date().getTime();

        const timeEnd = ref(null);

        let timer = setInterval(() => {
            let now = new Date().getTime() + dispute.value;
            let lastTime = (now - start - dispute.value) / 1000;

            timeEnd.value = time - lastTime;

            let seconds = Math.floor(timeEnd.value % 60);
            timeEnd.value /= 60;
            let minutes = Math.floor(timeEnd.value % 60);
            timeEnd.value /= 60;
            let hour = Math.floor(timeEnd.value % 60);

            timeEnd.value =
                Math.floor(hour) +
                ":" +
                Math.floor(minutes) +
                ":" +
                Math.floor(seconds);

            if (timeEnd.value == "0:0:0") {
                emit("finish", true);
                clearInterval(timer);
            }
        }, 1000);

        return {
            timeEnd,
        };
    },
};
</script>

<style></style>
