import { createStore } from "vuex";

export default createStore({
    state() {
        return {
            questions: {},
            questionsLength: 0,
        };
    },
    mutations: {
        editQuestions(state, { question, index }) {
            state.questions[index] = question;
        },

        addQuestions(state, index) {
            state.questions = { ...state.questions, [index]: {} };
            state.questionsLength++;
        },

        removeQuestion(state, index) {
            delete state.questions[index];
            state.questionsLength--;
        },
    },
    getters: {
        getQuestions(state) {
            return state.questions;
        },

        getSizeQuestions(state) {
            return state.questionsLength;
        },
    },
});
