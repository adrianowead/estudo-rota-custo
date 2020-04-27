var AsaQuebrada = (function () {
    function AsaQuebrada() {
        this.nextStep = 0;
        this.inputs = [];
        this.collected = [];
        this.waitingServer = false;
        this.from = '';
        this.to = '';
        this.start();
    }
    AsaQuebrada.prototype.performAjax = function (method, resource, success, error) {
        var _this = this;
        if (method === void 0) { method = 'GET'; }
        if (!this.waitingServer) {
            this.waitingServer = true;
            var xhr = new XMLHttpRequest();
            xhr.open(method, resource);
            xhr.onload = function () {
                _this.waitingServer = false;
                if (xhr.status === 200) {
                    success(xhr.responseText);
                }
                else {
                    error(xhr.status);
                }
            };
            xhr.send();
        }
    };
    AsaQuebrada.prototype.performStep = function (step) {
        var _this = this;
        for (var i = 0; i < this.inputs.length; i++) {
            step.text = step.text.replace(this.inputs[i].namespace, this.inputs[i].value);
        }
        this.setMessage(step.text);
        this.nextStep = step.next;
        if (!step.required) {
            this.setStatus('');
            setTimeout(function () {
                _this.requestNextStep();
            }, (step.wait * 1000));
        }
        else {
            this.setStatus('aguardando resposta...');
            this.showInput(function (value) {
                if (_this.collected.indexOf(step.namespace) < 0) {
                    _this.collected.push(step.namespace);
                    _this.inputs.push({
                        "namespace": step.namespace,
                        "value": value
                    });
                    if (step.namespace == '%pontoOrigem%') {
                        _this.from = value;
                    }
                    if (step.namespace == '%pontoDestino%') {
                        _this.to = value;
                    }
                }
                _this.watchParams();
                _this.requestNextStep();
            });
        }
    };
    AsaQuebrada.prototype.watchParams = function () {
        var _this = this;
        if (this.from.length > 0 && this.to.length > 0) {
            this.waitingServer = false;
            this.performAjax('GET', "/quote/" + this.from + "/" + this.to, function (success) {
                success = JSON.parse(success);
                success.route = success.route.split(',');
                _this.inputs.push({
                    "namespace": "%checkPoints%",
                    "value": "<br>" + success.route.join(' -> ')
                });
                _this.inputs.push({
                    "namespace": "%tipoDeViajem%",
                    "value": (success.route.length > 2 ? "com escala" : "direto")
                });
                _this.inputs.push({
                    "namespace": "%valorTotal%",
                    "value": "R$ " + success.price + ",00"
                });
            }, function (err) {
                _this.setMessage("Ops, algo deu errado :(, temos que reiniciar");
                _this.setStatus("...reiniciando...");
                console.log(err);
                setTimeout(function () {
                    window.top.location.reload();
                }, 5);
            });
        }
    };
    AsaQuebrada.prototype.showInput = function (callback) {
        var field = document.getElementById("field");
        field.style.display = "inline-block";
        field.querySelector("input").focus();
        field.querySelector("input").addEventListener("keyup", function (evt) {
            if (evt.keyCode == 13) {
                field.style.display = "none";
                field.querySelector("input").blur();
                field.querySelector("input").removeEventListener("keyup", function () { });
                callback(field.querySelector("input").value + "");
                setTimeout(function () {
                    field.querySelector("input").value = '';
                }, 500);
            }
        });
    };
    AsaQuebrada.prototype.requestNextStep = function () {
        var _this = this;
        if (typeof (this.nextStep) != "number") {
            return false;
        }
        this.performAjax('GET', "/step/" + this.nextStep, function (success) {
            _this.performStep(JSON.parse(success));
        }, function (err) {
            _this.setMessage("Ops, algo deu errado :(, temos que reiniciar");
            _this.setStatus("...reiniciando...");
            console.log(err);
            setTimeout(function () {
                window.top.location.reload();
            }, 5);
        });
    };
    AsaQuebrada.prototype.start = function () {
        this.setMessage("Carregando...");
        this.setStatus("...inicializando...");
        this.requestNextStep();
    };
    AsaQuebrada.prototype.setMessage = function (messsage) {
        document.getElementById("message").innerHTML = messsage;
    };
    AsaQuebrada.prototype.setStatus = function (messsage) {
        var status = document.getElementById("status");
        status.innerHTML = messsage;
        if (messsage.length == 0) {
            status.style.display = "none";
        }
        else {
            status.style.display = "block";
        }
    };
    return AsaQuebrada;
}());
new AsaQuebrada;
