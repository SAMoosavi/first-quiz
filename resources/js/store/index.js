import { createStore } from "vuex";

export default createStore({
    state() {
        return {
            // Creat Quiz
            questions: {},
            lengthQuestions: 0,
            // Answer Quiz
            answers: {},
            noAnswer: 0,
            // Point Student Quiz
            pointsOfStudents: {},
            pointOfStudents: {},
        };
    },
    mutations: {
        // Creat Quiz
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
        clearQuestions(state) {
            state.questions = {};
            state.lengthQuestions = 0;
        },
        // Answer Quiz
        addAnswer(state, { index, ans }) {
            let answer;
            if (ans.ans) {
                answer = ans.ans;
            } else {
                answer = "";
                state.noAnswer++;
            }
            state.answers = {
                ...state.answers,
                [index]: { id: ans.id, ans: answer, type: ans.type },
            };
        },
        editAnswer(state, { index, ans }) {
            if (ans.ans == "" && state.answers[index].ans != "")
                state.noAnswer++;
            if (ans.ans != "" && state.answers[index].ans == "")
                state.noAnswer--;
            state.answers[index].ans = ans.ans;
        },
        // Point Student Quiz
        addStudent(state, studentId) {
            state.pointsOfStudents = {
                ...state.pointsOfStudents,
                [studentId]: {},
            };
        },
        addQuestionId(state, { studentId, questionId, point }) {
            state.pointsOfStudents[studentId] = {
                ...state.pointsOfStudents[studentId],
                [questionId]: point,
            };

            localStorage.setItem(`${studentId},${questionId}`, point);

            let quizPoint = 0;
            for (const questionId in state.pointsOfStudents[studentId]) {
                const point = state.pointsOfStudents[studentId][questionId];
                quizPoint += parseFloat(point) ? parseFloat(point) : 0;
            }
            quizPoint = quizPoint.toFixed(2);
            state.pointOfStudents[studentId] = quizPoint;
            localStorage.setItem(`${studentId},*`, quizPoint);
        },
        pointQuestion(state, { studentId, questionId, point }) {
            let pVal = state.pointsOfStudents[studentId][questionId];
            let val = point;
            state.pointsOfStudents[studentId][questionId] = point;
            localStorage.setItem(`${studentId},${questionId}`, val);

            let quizPoint = state.pointOfStudents[studentId];
            quizPoint -= parseFloat(pVal) ? parseFloat(pVal) : 0;
            quizPoint += parseFloat(val) ? parseFloat(val) : 0;
            quizPoint = quizPoint.toFixed(2);
            state.pointOfStudents[studentId] = quizPoint;
            localStorage.setItem(`${studentId},*`, quizPoint);
        },
        removePoint(state, studentId) {
            delete state.pointsOfStudents[studentId];
            delete state.pointOfStudents[studentId];
        },
    },
    getters: {
        // Creat Quiz
        getQuestions(state) {
            return state.questions;
        },
        getSizeQuestions(state) {
            return state.lengthQuestions;
        },
        // Answer Quiz
        getAnswer(state) {
            return state.answers;
        },
        getNoAnswer(state) {
            return state.noAnswer;
        },
        // Point Student Quiz
        getPointOfStudents(state) {
            return state.pointsOfStudents;
        },
        getSumPointOfStudents(state) {
            return state.pointOfStudents;
        },
    },
});
