class TableManager extends Request {
    tbody = "";
    url = "";

    constructor(url) {
        super(url);
        this.tbody = document.querySelector("#table-block #users-table tbody");
        this.url = url;
    }

    sendRequest(cursor = "") {
        var url = this.url;

        if (cursor !== "") {
            url += "?cursor=" + cursor;
        }

        super.send(url, "GET", "", (data) => {
            var nextCursor = data.meta.next_cursor;

            if (nextCursor === "" || nextCursor === null) {
                this.hideSninner();
                return;
            }

            this.addRowWithData(data.data);

            this.sendRequest(nextCursor);
        });

        // fetch(url, {
        //     method: "GET",
        //     headers: {
        //         "Content-Type": "application/json",
        //         "Accept": "application/json",
        //         "X-CSRF-Token": "{{ csrf_token() }}"
        //     },
        // })
        // .then(response => {
        //     if (!response.ok) {
        //         this.showError("Проблемы с сервером")
        //
        //         return;
        //     }
        //     return response.json();
        // })
        // .then(data => {
        //     var nextCursor = data.meta.next_cursor;
        //
        //     if (nextCursor === "" || nextCursor === null) {
        //         this.hideSninner()
        //         return;
        //     }
        //
        //     this.addRowWithData(data.data)
        //
        //     this.sendRequest(nextCursor)
        // })
        // .catch(error => {
        //     this.showError(error)
        // });
    }

    hideSninner() {
        var spinner = document.querySelector(".spinner-border");

        spinner.style = "display: none;"
    }

    addRowWithData(data) {
        data.forEach((element) => {
            var row = this.tbody.insertRow();

            row.insertCell(0).textContent = element["id"];
            row.insertCell(1).textContent = element["name"];
            row.insertCell(2).textContent = element["email"];
        });
    }
}
