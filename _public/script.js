document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#form-cadastro');
    const emailInput = document.querySelector('#cadastroEmail');
    const senhaInput = document.querySelector('#cadastroSenha');
    const msgErroEmail = document.querySelector('#erro-email');
    const msgErroSenha = document.querySelector('#erro-senha');

    if (!form) return; // garante que não quebre se não for a tela de cadastro

    form.addEventListener('submit', function (e) {
        let valido = true;

        // Validação do e-mail
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput.value)) {
            msgErroEmail.textContent = "E-mail inválido.";
            valido = false;
        } else {
            msgErroEmail.textContent = "";
        }

        // Validação da senha
        const senha = senhaInput.value;
        const senhaRegex = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%&*]).{8,}$/;

        if (!senhaRegex.test(senha)) {
            msgErroSenha.textContent = "Senha inválida. Mínimo 8 caracteres, com letra maiúscula, número e caractere especial (!@#$%&*).";
            valido = false;
        } else {
            msgErroSenha.textContent = "";
        }

        if (!valido) {
            e.preventDefault(); // impede envio se houver erro
        }
    });
});
