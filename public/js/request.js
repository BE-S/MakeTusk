class Request {
    showError(msg) {
        var errorBlock = document.querySelector("#table-block .error-load");

        errorBlock.style = "";
        errorBlock.innerHTML = msg;
    }

    send(url, method = "GET", params = "", callback) {
        var requestBody = {
            method: method,
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
        };

        if (method !== "GET" && method !== "HEAD") {
            requestBody["body"] = params;
        }

        fetch(url, requestBody)
            .then(response => {
                if (!response.ok) {
                    this.showError("Проблемы с сервером")

                    return;
                }
                return response.json();
            })
            .then(data => {
                callback(data);
            })
            .catch(error => {
                this.showError(error)
            });
    }
}
