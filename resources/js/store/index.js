import { createStore } from "vuex";

export default createStore({
    state() {
        return {
            questions: {},
            answers: {},
        };
    },
    mutations: {
        editQuestions(state, { question, index }) {
            state.questions[index] = question;
        },

        addQuestions(state, index) {
            state.questions = { ...state.questions, [index]: {} };
        },

        removeQuestion(state, index) {
            delete state.questions[index];
        },

        addAnswer(state, { index, ans }) {
            state.answers = { ...state.answers, [index]: {uuid: ans.uuid} };
            
        },
        editAnswer(state, { index, ans }) {
            state.answers[index] = ans;
        },
    },
    getters: {
        getQuestions(state) {
            return state.questions;
        },

        getSizeQuestions(state) {
            return state.questions.length;
        },

        getAnswer(state) {
            return state.answers;
        },
    },
});
