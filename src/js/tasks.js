const app = new Vue({

  el: "#app",

  mounted() {
    if (window.location.href.search('000webhostapp') > -1) {
      document.getElementsByTagName("body")[0].children[2].remove()
    };

    if (document.cookie.search("user") === -1) {

      window.location.href = "/";

      return;

    };

    fetch("/php/tasks.php", { credentials: "include", method: "GET" })

      .then(async response => {

        const data = await response.json();

        app.tasks = data.tasks;

        app.login = data.user_login;

      })

      .catch(e => {

        console.dir(e);

        // window.location.href = "/";

      });

  },

  data: {

    login: "",

    tasks: [],

    newTaskText: "",

    search: ""

  },

  computed: {

    tasksWithSearch() {

      const serachText = this.search.toLowerCase();

      return this.tasks.filter(

        task => task.text.toLowerCase().search(serachText) > -1

      );

    },

    state() {

      const allTasks = this.tasks.length;

      const doneTasks = this.tasks.filter(task => task.done == 1).length;



      return `Выполнено задач ${doneTasks} из ${allTasks}.`;

    }

  },

  methods: {

    addTask() {

      const body = new FormData();

      body.set("task_text", this.newTaskText);



      fetch("/php/addTask.php", {

        credentials: "include",

        method: "POST",

        body

      })

        .then(() => {

          this.tasks.push({

            _id: this.tasks.length + 1,

            text: this.newTaskText,

            done: 0

          });



          this.newTaskText = "";

        })

        .catch(err => {

          console.log(err);

          alert("Не удалось добавить задачу");

        });

    },

    changeState(event, taskId, done) {

      const newState = done == 1 ? 0 : 1;



      const body = new FormData();

      body.set("task_id", taskId);

      body.set("done", newState);



      fetch("/php/tasks.php", {

        credentials: "include",

        method: "POST",

        body

      })

        .then(() => {

          this.updateState(taskId);

        })

        .catch(er => {

          console.log(er);

          alert("Не удалось изменить задачу");

        });

    },

    updateState(taskId) {

      const taskIndex = this.tasks.findIndex(task => task._id == taskId);

      this.tasks[taskIndex].done = this.tasks[taskIndex].done == 1 ? 0 : 1;

    },

    signout() {

      document.cookie = "user=; path=/; expires=" + new Date(0).toUTCString();

      window.location.href = "/";

    }

  }

});

