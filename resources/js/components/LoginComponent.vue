<template>
    <div class="login-container">
        <span class="error animated tada" id="msg"></span>
        <div name="loginForm" class="box">
            <h4>Accent Group Admin <span>Dashboard</span></h4>
            <h5>Sign in to your account.</h5>
            <span class="error" id="loginErrMsg">{{loginErrMsg}}</span>
            <input type="text" name="email" id="email" placeholder="Email" autocomplete="off" v-model="email" v-on:keyup.enter="doLogin">
            <div class="error-msg">{{emailErrMsg}}</div>
            <i :class=" isEyeOpen ? 'typcn typcn-eye active':'typcn typcn-eye'" id="eye" @click="isEyeOpen = !isEyeOpen"></i>
            <input id="password" :type="isEyeOpen ? 'text':'password'" name="password" placeholder="Passsword" autocomplete="off" v-model="password" v-on:keyup.enter="doLogin">
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
            $("#loginErrMsg").hide();
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
            axios.post('/auth/user', params)
                .then(response=>{
                    if(response.data.code === 200){
                        window.location.href = '/';
                    }else if(response.data.code === 401){
                        this.loginErrMsg = "incorrect email or password.";
                        this.submitted = false;
                        $("#loginErrMsg").show();
                    }else{
                        this.loginErrMsg = "invalid email or password.";
                        this.submitted = false;
                        $("#loginErrMsg").show();
                    }
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
