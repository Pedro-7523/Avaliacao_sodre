SELECT
    cargos_funcionarios.nome_cargo AS Cargo,
    COUNT(funcionario.nome_funcionario) AS Qtde_Funcionários,
    SUM(funcionario.salario) AS Total_salário
FROM
    cargos_funcionarios
    INNER JOIN funcionario ON cargos_funcionarios.id_cargo = funcionario.cargo_id
GROUP BY
    cargos_funcionarios.id_cargo
ORDER BY FIELD(
        cargos_funcionarios.nome_cargo, 'Analista de Sistemas', 'Administrador', 'Gestor'
    );