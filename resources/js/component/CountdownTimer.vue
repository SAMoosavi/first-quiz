<template>
    {{ timeEnd ? timeEnd : "زمان باقی مانده" }}
</template>

<script setup>
import { ref } from "@vue/reactivity";

const props = defineProps(["time", "start", "now"]);
const emit = defineEmits(["finish"]);

let time = props.time;
time = time.split(":");
time = time[0] * 60 * 60 + time[1] * 60 + time[2] * 1;
let dispute = ref(props.now * 1000 - new Date().getTime());

const start = props.start * 1000;

const timeEnd = ref(null);

function toTwoNumber(num) {
    return Math.abs(num) > 9 ? num : `0${num}`;
}

let timer = setInterval(() => {
    let now = new Date().getTime() + dispute.value;
    let lastTime = (now - start) / 1000;

    timeEnd.value = time - lastTime;
    if (timeEnd.value > 0) {
        let seconds = Math.floor(timeEnd.value % 60);
        timeEnd.value /= 60;
        let minutes = Math.floor(timeEnd.value % 60);
        timeEnd.value /= 60;
        let hour = Math.floor(timeEnd.value % 60);
        timeEnd.value =
            toTwoNumber(hour) +
            ":" +
            toTwoNumber(minutes) +
            ":" +
            toTwoNumber(seconds);
    } else {
        timeEnd.value = "00:00:00";
    }

    if (time - lastTime < 0) {
        emit("finish", true);
        clearInterval(timer);
    }
}, 1000);
</script>
