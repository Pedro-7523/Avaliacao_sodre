SELECT
    funcionario.nome_funcionario AS Funcionário,
    cargos_funcionarios.nome_cargo AS Cargo,
    funcionario.salario AS Salário
FROM
    funcionario
    INNER JOIN cargos_funcionarios ON funcionario.cargo_id = id_cargo
ORDER BY FIELD(
        cargos_funcionarios.nome_cargo, 'Analista de Sistemas', 'Administrador', 'Gestor'
    );