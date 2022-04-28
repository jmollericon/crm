<template>
  <div id="right">
    <h1>Development CRM</h1>

    <div class="horizontal">
      <img src="/images/horizontal.png" alt="horizontal">
    </div>

    <p>
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, voluptatum fuga ab recusandae et dolorum ratione a officia culpa ducimus vitae ea accusantium ex. Fuga excepturi numquam doloribus dignissimos rerum?
    </p>

    <div class="users-icon"><img src="/images/users.png" /></div>

    <div class="tasks">
      <div class="add-tasks">
        <h2>Today's Task</h2>

        <div class="add-action">
          <img src="/images/add.png" alt="add">
        </div>
      </div>

      <ul class="tasks-list">
        <li v-for="task in todayTasks" v-bind:key="task.id">
          <div class="info">
            <div class="left">
              <label class="myCheckbox">
                <input
                  type="checkbox"
                  name="test"
                  :checked="task.completed"
                  @change="updateTodayTask(task.taskId)"
                />
                <span></span>
              </label>

              <h4>{{task.title}}</h4>
            </div>

            <div class="right">
              <img src="/images/edit.png" alt="edit" />
              <img src="/images/del.png" alt="del" @click="deleteTask(task.taskId)"/>
              <button
                v-bind:class="{
                  inprogress: !task.approved,
                  approved: task.approved,
                }"
              >
                {{ task.approved ? "Approved" : "In progress" }}
              </button>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div class="upcoming">
      <div class="add-tasks">
        <h2>Upcoming</h2>

        <div class="add-action">
          <img src="/images/add.png" alt="add" />
        </div>
      </div>

      <form action="" @submit="addUpcomingTask">
        <input type="text" v-model="newTask" />
      </form>

      <ul class="tasks-list">
        <li v-for="upcomingtask in upcoming" v-bind:key="upcomingtask.id">
          <div class="info">
            <div class="left">
              <label class="myCheckbox">
                <input
                  type="checkbox"
                  name="test"
                  :checked="upcomingtask.completed"
                  @change="checkUpcomingTask(upcomingtask.taskId)"
                />
                <span></span>
              </label>

              <h4>{{upcomingtask.title}}</h4>
            </div>

            <div class="right">
              <img src="/images/edit.png" alt="edit" />
              <img src="/images/del.png" alt="del" @click="deleteUpcomingTask(upcomingtask.taskId)"/>
              <button
                v-bind:class="{
                  inprogress: !upcomingtask.approved,
                  approved: upcomingtask.approved,
                }"
              >
                {{ upcomingtask.approved ? "Approved" : "In progress" }}
              </button>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      todayTasks: [],
      upcoming: [],
      newTask: "",
    };
  },
  created() {
    this.fetchTodayTasks();
    this.fetchUpcoming();
  },
  methods: {
    fetchUpcoming() {
      fetch('/api/upcoming')
        .then(res => res.json())
        .then(({ data }) => {
          this.upcoming = data;
        })
        .catch(err => console.log({ err }));
    },
    fetchTodayTasks() {
      fetch('/api/dailytask')
        .then(res => res.json())
        .then(({ data }) => {
          this.todayTasks = data;
        })
        .catch(err => console.log({ err }));
    },
    addUpcomingTask(e) {
      e.preventDefault();
      if (this.newTask === '') {
        return alert('Please type a description of upcoming task')
      }
      if (this.upcoming.length > 4) {
        return alert("Please complete the upcoming task");
      }
      const newTask = {
        title: this.newTask,
        waiting: true,
        taskId: Math.random().toString(36).substring(7),
      };

      fetch("/api/upcoming", {
        method: "POST",
        headers: {
          "content-type": "application/json",
        },
        body: JSON.stringify(newTask),
      }).then(() => this.upcoming.push(newTask));

      this.newTask = "";
    },
    deleteUpcomingTask(taskId) {
      if(confirm("Are you sure?")) {
        fetch(`/api/upcoming/${taskId}`, { method: 'DELETE' })
          .then(res => res.json())
          .then(() => {
            this.upcoming = this.upcoming.filter(({ taskId: id }) => id !== taskId);
          })
          .catch(err => console.log({ err }));
      }
    },
    checkUpcomingTask(taskId) {
      if (this.todayTasks.length > 4) {
        alert("sorry complete existing task");
        window.location.href = "/";
      } else {
        this.addDailyTask(taskId);

        fetch(`api/upcoming/${taskId}`, { method: 'DELETE' })
          .then(res => res.json())
          .then(() => {
            this.upcoming = this.upcoming.filter(({ taskId: id }) => id !== taskId);
          })
          .catch(err => console.log({ err }));
      }
    },
    addDailyTask(taskId) {
      const task = this.upcoming.find(({ taskId: id }) => id == taskId);

      fetch("api/dailytask", {
        method: "POST",
        headers: {
          "content-type": "application/json"
        },
        body: JSON.stringify(task),
      })
        .then(res => res.json())
        .then(() => this.todayTasks.unshift(task))
        .catch(err => console.log({ err }));
    },
    deleteTask(taskId) {
      if(confirm("Are you sure?")) {
        fetch(`/api/dailytask/${taskId}`, { method: 'DELETE' })
          .then(res => res.json())
          .then(() => {
            this.todayTasks = this.todayTasks.filter(({ taskId: id }) => id !== taskId);
          })
          .catch(err => console.log({ err }));
      }
    },
    updateTodayTask(taskId) {
      if (confirm("Task completed?")) {
        fetch(`/api/dailytask/${taskId}`, { method: "DELETE" })
          .then(() => {})
          .then(() => {
            this.todayTasks = this.todayTasks.filter(({ taskId: id }) => id !== taskId);
          })
          .catch(err => console.log({ err }));
      }
    }
  }
}
</script>

<style>

</style>
