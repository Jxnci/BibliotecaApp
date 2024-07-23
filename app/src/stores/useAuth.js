import { defineStore } from "pinia";

const useAuth = defineStore("Auth", {
  state: () => {
    return {
      token: null,
      baseURL: "http://127.0.0.1:8000/api",
    };
  },
  actions: {
    async register(name,lastname, email, password) {
      const uri = `${this.baseURL}/register`;
      const rawResponse = await fetch(uri, {
        method: "POST",
        headers: {
          "Content-Type": "Application/json",
          "Accept": "Application/json",
        },
        body: JSON.stringify({
          name: name,
          email: email,
          lastname: lastname,
          password: password,
        }),
      });
      const response = await rawResponse.json();
      if (response.status == false) {
        return false;
      } else {
        this.token = response.token;
        return true;
      }
    },
    async login(email, password) {
      try {
        const uri = `${this.baseURL}/login`;
        const rawResponse = await fetch(uri, {
          method: "POST",
          headers: {
            "Content-Type": "Application/json",
            "Accept": "Application/json",
          },
          body: JSON.stringify({
            email: email,
            password: password,
          }),
        });
        const response = await rawResponse.json();
        if (response.status == false) {
          this.token = null;
          return false;
        } else {
          this.token = response.token;
          return true;
        }
      } catch (error) {
        return false;
      }
    },
    logout() {
      this.token = null;
    },
  },
});

export default useAuth;
