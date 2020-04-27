class AsaQuebrada {
    private nextStep: number = 0;
    private inputs: any = [];
    private collected: any = [];
    private waitingServer: boolean = false;
    private from: string = '';
    private to: string = '';
    private nomeCliente: string = '';

    constructor() {
        this.start();
    }

    private performAjax(method: string = 'GET', resource: string, success: Function, error: Function) {
        if (!this.waitingServer) {
            this.waitingServer = true;

            var xhr = new XMLHttpRequest();
            xhr.open(method, resource);
            xhr.onload = () => {
                this.waitingServer = false;

                if (xhr.status === 200) {
                    success(xhr.responseText);
                }
                else {
                    error(xhr.status);
                }
            };
            xhr.send();
        }
    }

    private performStep(step: any) {
        for (let i = 0; i < this.inputs.length; i++) {
            step.text = step.text.replace(this.inputs[i].namespace, this.inputs[i].value);
        }

        this.setMessage(step.text);
        this.nextStep = step.next;

        if (!step.required) {
            this.setStatus('');

            setTimeout(() => {
                this.requestNextStep();
            }, (step.wait * 1000));
        } else {
            this.setStatus('aguardando resposta...');
            this.showInput((value: string) => {
                if (this.collected.indexOf(step.namespace) < 0) {
                    this.collected.push(step.namespace);

                    this.inputs.push({
                        "namespace": step.namespace,
                        "value": value
                    });

                    if (step.namespace == '%pontoOrigem%') {
                        this.from = value;
                    }

                    if (step.namespace == '%pontoDestino%') {
                        this.to = value;
                    }

                    if (step.namespace == '%nomeUsuario%') {
                        this.nomeCliente = value;
                    }
                }

                this.watchParams();

                this.requestNextStep();
            });
        }
    }

    private watchParams() {
        if (this.from.length > 0 && this.to.length > 0) {
            this.waitingServer = false;

            this.performAjax(
                'GET',
                `/quote/${this.from}/${this.to}`,
                (success: any) => {
                    success = JSON.parse(success);
                    success.route = success.route.split(',');

                    this.inputs.push({
                        "namespace": "%checkPoints%",
                        "value": `<br>${success.route.join(' -> ')}`
                    });

                    this.inputs.push({
                        "namespace": "%tipoDeViajem%",
                        "value": (success.route.length > 2 ? "com escala" : "direto")
                    });

                    this.inputs.push({
                        "namespace": "%valorTotal%",
                        "value": `R$ ${success.price},00`
                    });
                },
                (err: any) => {
                    this.setMessage("Ops, algo deu errado :(, temos que reiniciar");
                    this.setStatus("...reiniciando...");

                    console.log(err);

                    setTimeout(() => {
                        window.top.location.reload();
                    }, 5);
                }
            );
        }
    }

    private showInput(callback: Function) {
        const field = document.getElementById("field");

        field.style.display = "inline-block";
        field.querySelector("input").focus();

        field.querySelector("input").addEventListener("keyup", evt => {
            if (evt.keyCode == 13) {
                field.style.display = "none";
                field.querySelector("input").blur();
                field.querySelector("input").removeEventListener("keyup", () => { });

                callback(field.querySelector("input").value + "");

                setTimeout(() => {
                    field.querySelector("input").value = '';
                }, 500);
            }
        });
    }

    private requestNextStep() {
        if (this.nextStep == 15) {
            this.cortesia();
        }

        if (typeof (this.nextStep) != "number") {
            return false;
        }

        this.performAjax(
            'GET',
            `/step/${this.nextStep}`,
            (success: string) => {
                this.performStep(JSON.parse(success));
            },
            (err: any) => {
                this.setMessage("Ops, algo deu errado :(, temos que reiniciar");
                this.setStatus("...reiniciando...");

                console.log(err);

                setTimeout(() => {
                    window.top.location.reload();
                }, 5);
            }
        );
    }

    private start() {
        this.setMessage("Carregando...");
        this.setStatus("...inicializando...");

        this.requestNextStep();
    }

    private setMessage(message: string) {
        message = message.trim();

        if (message.length > 0) {
            document.getElementById("message").innerHTML = message;
        }
    }

    private setStatus(messsage: string) {
        const status = document.getElementById("status");

        status.innerHTML = messsage;

        if (messsage.length == 0) {
            status.style.display = "none";
        } else {
            status.style.display = "block";
        }
    }

    private cortesia() {
        this.setMessage(`Agora ${this.nomeCliente}, pegue sua pipoca 🍿, e desfrute de nossa programação à bordo 🤓`);

        // @ts-ignore: Unreachable code error
        Start(); // função externa
    }
}

new AsaQuebrada;
