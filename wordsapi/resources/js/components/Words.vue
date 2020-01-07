<template>
    <div class="container">
        <h2>Try It</h2>
        <p>Enter a word to lookup and what you want the API to return.</p>
        <div class="row">
            <div class="col-4 col-md-4">
                <div class="form-group">
                    <label class="d-block">Enter a Word</label>
                    <input
                        name="word"
                        v-model="word"
                        type="text"
                        autofocus
                        placeholder="example"
                        class="w-100"
                    />
                </div>
                <div class="form-group">
                    <label class="d-block">What to Get</label>
                    <input
                        name="type"
                        v-model="type"
                        type="text"
                        placeholder="Definitions"
                        class="w-100"
                        disabled
                    />
                </div>
                <button class="btn btn-success w-100" @click="callWordsAPI()">
                    Call the API
                </button>
            </div>
            <div class="col-8 col-md-5">
                <div class="form-group">
                    <label class="d-block">Request URL</label>
                    <input
                        name="request_url"
                        v-model="request_url"
                        type="text"
                        class="w-100 small"
                        disabled
                    />
                </div>
                <div class="form-group">
                    <label class="d-block">Response</label>
                    <div class="word-response">{{ wordsRes }}</div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label class="d-block">Previous searches</label>
                    <div class="word-response">
                        <p v-for="(word, ind) in recent_words" :key="ind">
                            {{ word }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            word: "",
            type: "",
            wordsRes: "",
            request_url: "",
            recent_words: []
        };
    },
    mounted() {
        console.log("Component mounted.");
        this.getRecentWords();
    },
    methods: {
        getRecentWords() {
            axios
                .get("/api/get-recent-words", { word: this.word })
                .then(response => {
                    console.log(response);
                    let res = response.data;
                    if (res.status == "success") {
                        this.recent_words = res.data;
                    }
                });
        },
        callWordsAPI() {
            if (this.word) {
                axios
                    .post("/api/search-words", { word: this.word })
                    .then(response => {
                        console.log(response);
                        let res = response.data;
                        if (res.status == "success") {
                            this.wordsRes = res.data.body;
                            this.request_url = res.data.url;
                            this.recent_words.unshift(this.word);
                        }
                    });
            }
        }
    }
};
</script>
<style scoped>
.word-response {
    width: 100%;
    min-height: 150px;
    padding: 16px;
    color: black;
    background: white;
    border-radius: 4px;
    overflow-y: scroll;
}
.word-response p {
    margin-bottom: 0;
}
</style>
