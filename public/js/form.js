class FormRequest extends Request {
    formData;

    constructor() {
        super();

        var forms = document.querySelectorAll("form");

        forms.forEach((form) => {
            var button = form.querySelector("button[type=\"submit\"]");

            button.addEventListener("click", (e) => {
                e.preventDefault();

                var url = form.action;
                var method = form.method;

                var data = {};

                form.querySelectorAll("input").forEach((input) => {
                    data[input.name] = input.value;
                })


                super.send(url, method, JSON.stringify(data), function (data) {
                    var status = data.status;

                    if (status === "success") {
                        alert(data.message);
                    }
                });
            });
        })
    }
}
