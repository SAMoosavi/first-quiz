import { createStore } from "vuex";

export default createStore({
    state() {
        return {
            questions: {},
            lengthQuestions: 0,
            answers: {},
        };
    },
    mutations: {
        editQuestions(state, { question, index }) {
            state.questions[index] = question;
        },

        addQuestions(state, index) {
            state.questions = { ...state.questions, [index]: {} };
            state.lengthQuestions++;
        },

        removeQuestion(state, index) {
            delete state.questions[index];
            state.lengthQuestions--;
        },

        addAnswer(state, { index, ans }) {
            state.answers = {...state.answers, [index]: { id: ans.id, ans: ans.ans, ype: ans.type, }, };
        },
        editAnswer(state, { index, ans }) {
            state.answers[index].ans = ans.ans;
        },
    },
    getters: {
        getQuestions(state) {
            return state.questions;
        },

        getSizeQuestions(state) {
            return state.lengthQuestions;
        },

        getAnswer(state) {
            return state.answers;
        },
    },
});
