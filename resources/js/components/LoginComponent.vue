<template>
    <div class="login-container">
        <span class="error animated tada" id="msg"></span>
        <div name="loginForm" class="box" action="" method="POST">
            <h4>Accent Group Admin <span>Dashboard</span></h4>
            <h5>Sign in to your account.</h5>
            <span class="error">{{loginErrMsg}}</span>
            <input type="text" name="email" id="email" placeholder="Email" autocomplete="off" v-model="email">
            <div class="error-msg">{{emailErrMsg}}</div>
            <i :class=" isEyeOpen ? 'typcn typcn-eye active':'typcn typcn-eye'" id="eye" @click="isEyeOpen = !isEyeOpen"></i>
            <input id="password" :type="isEyeOpen ? 'text':'password'" name="password" placeholder="Passsword" autocomplete="off" v-model="password">
            <div class="error-msg">{{passwordErrMsg}}</div>
            <input type="button" @click="doLogin" :value="submitted?'Logging...':'Sign in'" class="btn1">
        </div>
    </div>
</template>

<script>
export default {
    name: 'Login',
    props: {
        source: String,
    },
    data() {
        return {
            email: "",
            password: "",
            isEyeOpen: false,
            emailErrMsg: "",
            passwordErrMsg: "",
            loginErrMsg: "",
            submitted: false
        }
    },
    watch: {
        password (val){
            if(val !== "") {
                this.passwordErrMsg = "";
            }else{
                this.passwordErrMsg = "Please fill in the blank."
            }
        },
        email (val){
            if(val !== ""){
                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (!re.test(this.email)) {
                    this.emailErrMsg = "Please enter a valid email.";
                }else{
                    this.emailErrMsg = "";
                }
            }
        }
    },
    methods: {
        doLogin(){
            if(this.email === ""){
                this.emailErrMsg = "Please fill in the blank.";
                $("#email").focus();
                return false;
            }else{
                this.emailErrMsg = "";
            }

            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (!re.test(this.email)) {
                this.emailErrMsg = "Please enter a valid email.";
                $("#email").focus();
                return false;
            } else {
                this.emailErrMsg = "";
            }

            if(this.password === ""){
                this.passwordErrMsg = "Please fill in the blank.";
                $("#password").focus();
                return false;
            }else{
                this.passwordErrMsg = "";
            }


            const params = {
                email: this.email,
                password: this.password
            };
            this.submitted = true;
            axios.post('/api/auth/user', params)
                .then(response=>{
                    var headers = response.headers;
                    console.log(headers);
                    window.sessionStorage.accessToken = response.data.access_token;
                    console.log(document.cookie);
                    console.log(access_token);
                    //console.log('response');
                    //window.location.href = "/";
                })
                .catch(error=>{
                    this.submitted = false;
                    console.log(error);
            });
        }
    }
};
</script>

<style></style>
