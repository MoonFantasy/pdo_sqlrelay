--TEST--
PDO SQLRELAY MySQL PDOStatement->bindValue()
--SKIPIF--
<?php include "pdo_sqlrelay_mysql_skipif.inc"?>
--FILE--
<?php
include "PDOSqlrelayMysqlTestConfig.inc";
$db = PDOSqlrelayMysqlTestConfig::PDOFactory();
PDOSqlrelayMysqlTestConfig::createTestTable($db);

try {

	printf("Binding variable...\n");
	$stmt = $db->prepare('SELECT id, label FROM test WHERE id > ? ORDER BY id ASC LIMIT 2');
	$in = 0;
	if (!$stmt->bindValue(1, $in))
		printf("[003] Cannot bind value, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	$stmt->execute();
	$id = $label = null;

	if (!$stmt->bindColumn(1, $id, PDO::PARAM_INT))
		printf("[004] Cannot bind integer column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	if (!$stmt->bindColumn(2, $label, PDO::PARAM_STR))
		printf("[005] Cannot bind string column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	while ($stmt->fetch(PDO::FETCH_BOUND))
		printf("in = %d -> id = %s (%s) / label = %s (%s)\n",
			$in,
			var_export($id, true), gettype($id),
			var_export($label, true), gettype($label));

	printf("Binding value and not variable...\n");
	if (!$stmt->bindValue(1, 0))
		printf("[006] Cannot bind value, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	$stmt->execute();
	$id = $label = null;

	if (!$stmt->bindColumn(1, $id, PDO::PARAM_INT))
		printf("[007] Cannot bind integer column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	if (!$stmt->bindColumn(2, $label, PDO::PARAM_STR))
		printf("[008] Cannot bind string column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	while ($stmt->fetch(PDO::FETCH_BOUND))
		printf("in = %d -> id = %s (%s) / label = %s (%s)\n",
			$in,
			var_export($id, true), gettype($id),
			var_export($label, true), gettype($label));

	printf("Binding variable which references another variable...\n");
	$in = 0;
	$in_ref = &$in;
	if (!$stmt->bindValue(1, $in_ref))
		printf("[009] Cannot bind value, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	$stmt->execute();
	$id = $label = null;

	if (!$stmt->bindColumn(1, $id, PDO::PARAM_INT))
		printf("[010] Cannot bind integer column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	if (!$stmt->bindColumn(2, $label, PDO::PARAM_STR))
		printf("[011] Cannot bind string column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	while ($stmt->fetch(PDO::FETCH_BOUND))
		printf("in = %d -> id = %s (%s) / label = %s (%s)\n",
			$in,
			var_export($id, true), gettype($id),
			var_export($label, true), gettype($label));


	printf("Binding a variable and a value...\n");
	$stmt = $db->prepare('SELECT id, label FROM test WHERE id > ? AND id <= ? ORDER BY id ASC LIMIT 2');
	$in = 0;
	if (!$stmt->bindValue(1, $in))
		printf("[012] Cannot bind value, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	if (!$stmt->bindValue(2, 2))
		printf("[013] Cannot bind value, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	$stmt->execute();
	$id = $label = null;

	if (!$stmt->bindColumn(1, $id, PDO::PARAM_INT))
		printf("[014] Cannot bind integer column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	if (!$stmt->bindColumn(2, $label, PDO::PARAM_STR))
		printf("[015] Cannot bind string column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	while ($stmt->fetch(PDO::FETCH_BOUND))
		printf("in = %d -> id = %s (%s) / label = %s (%s)\n",
			$in,
			var_export($id, true), gettype($id),
			var_export($label, true), gettype($label));

	printf("Binding a variable to two placeholders and changing the variable value in between the binds...\n");
	// variable value change shall have no impact
	$stmt = $db->prepare('SELECT id, label FROM test WHERE id > ? AND id <= ? ORDER BY id ASC LIMIT 2');
	$in = 0;
	if (!$stmt->bindValue(1, $in))
		printf("[016] Cannot bind value, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	$in = 2;
	if (!$stmt->bindValue(2, $in))
		printf("[017] Cannot bind value, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	$stmt->execute();
	$id = $label = null;

	if (!$stmt->bindColumn(1, $id, PDO::PARAM_INT))
		printf("[018] Cannot bind integer column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	if (!$stmt->bindColumn(2, $label, PDO::PARAM_STR))
		printf("[019] Cannot bind string column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	while ($stmt->fetch(PDO::FETCH_BOUND))
		printf("in = %d -> id = %s (%s) / label = %s (%s)\n",
			$in,
			var_export($id, true), gettype($id),
			var_export($label, true), gettype($label));

} catch (PDOException $e) {
	printf("[001] %s [%s] %s\n",
		$e->getMessage(), $db->errorCode(), implode(' ', $db->errorInfo()));
}

try {

	printf("Binding variable...\n");
	$stmt = $db->prepare('SELECT id, label FROM test WHERE id > ? ORDER BY id ASC LIMIT 2');
	$in = 0;
	if (!$stmt->bindValue(1, $in))
		printf("[003] Cannot bind value, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	$stmt->execute();
	$id = $label = null;

	if (!$stmt->bindColumn(1, $id, PDO::PARAM_INT))
		printf("[004] Cannot bind integer column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	if (!$stmt->bindColumn(2, $label, PDO::PARAM_STR))
		printf("[005] Cannot bind string column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	while ($stmt->fetch(PDO::FETCH_BOUND))
		printf("in = %d -> id = %s (%s) / label = %s (%s)\n",
			$in,
			var_export($id, true), gettype($id),
			var_export($label, true), gettype($label));

	printf("Binding value and not variable...\n");
	if (!$stmt->bindValue(1, 0))
		printf("[006] Cannot bind value, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	$stmt->execute();
	$id = $label = null;

	if (!$stmt->bindColumn(1, $id, PDO::PARAM_INT))
		printf("[007] Cannot bind integer column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	if (!$stmt->bindColumn(2, $label, PDO::PARAM_STR))
		printf("[008] Cannot bind string column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	while ($stmt->fetch(PDO::FETCH_BOUND))
		printf("in = %d -> id = %s (%s) / label = %s (%s)\n",
			$in,
			var_export($id, true), gettype($id),
			var_export($label, true), gettype($label));

	printf("Binding variable which references another variable...\n");
	$in = 0;
	$in_ref = &$in;
	if (!$stmt->bindValue(1, $in_ref))
		printf("[009] Cannot bind value, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	$stmt->execute();
	$id = $label = null;

	if (!$stmt->bindColumn(1, $id, PDO::PARAM_INT))
		printf("[010] Cannot bind integer column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	if (!$stmt->bindColumn(2, $label, PDO::PARAM_STR))
		printf("[011] Cannot bind string column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	while ($stmt->fetch(PDO::FETCH_BOUND))
		printf("in = %d -> id = %s (%s) / label = %s (%s)\n",
			$in,
			var_export($id, true), gettype($id),
			var_export($label, true), gettype($label));


	printf("Binding a variable and a value...\n");
	$stmt = $db->prepare('SELECT id, label FROM test WHERE id > ? AND id <= ? ORDER BY id ASC LIMIT 2');
	$in = 0;
	if (!$stmt->bindValue(1, $in))
		printf("[012] Cannot bind value, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	if (!$stmt->bindValue(2, 2))
		printf("[013] Cannot bind value, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	$stmt->execute();
	$id = $label = null;

	if (!$stmt->bindColumn(1, $id, PDO::PARAM_INT))
		printf("[014] Cannot bind integer column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	if (!$stmt->bindColumn(2, $label, PDO::PARAM_STR))
		printf("[015] Cannot bind string column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	while ($stmt->fetch(PDO::FETCH_BOUND))
		printf("in = %d -> id = %s (%s) / label = %s (%s)\n",
			$in,
			var_export($id, true), gettype($id),
			var_export($label, true), gettype($label));

	printf("Binding a variable to two placeholders and changing the variable value in between the binds...\n");
	// variable value change shall have no impact
	$stmt = $db->prepare('SELECT id, label FROM test WHERE id > ? AND id <= ? ORDER BY id ASC LIMIT 2');
	$in = 0;
	if (!$stmt->bindValue(1, $in))
		printf("[016] Cannot bind value, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	$in = 2;
	if (!$stmt->bindValue(2, $in))
		printf("[017] Cannot bind value, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	$stmt->execute();
	$id = $label = null;

	if (!$stmt->bindColumn(1, $id, PDO::PARAM_INT))
		printf("[018] Cannot bind integer column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	if (!$stmt->bindColumn(2, $label, PDO::PARAM_STR))
		printf("[019] Cannot bind string column, %s %s\n",
			$stmt->errorCode(), var_export($stmt->errorInfo(), true));

	while ($stmt->fetch(PDO::FETCH_BOUND))
		printf("in = %d -> id = %s (%s) / label = %s (%s)\n",
			$in,
			var_export($id, true), gettype($id),
			var_export($label, true), gettype($label));

} catch (PDOException $e) {
	printf("[001] %s [%s] %s\n",
		$e->getMessage(), $db->errorCode(), implode(' ', $db->errorInfo()));
}

print "done!";
?>
--CLEAN--
<?php
include "PDOSqlrelayMysqlTestConfig.inc";
PDOSqlrelayMysqlTestConfig::dropTestTable();
?>
--EXPECTF--
Binding variable...
in = 0 -> id = 1 (integer) / label = 'a' (string)
in = 0 -> id = 2 (integer) / label = 'b' (string)
Binding value and not variable...
in = 0 -> id = 1 (integer) / label = 'a' (string)
in = 0 -> id = 2 (integer) / label = 'b' (string)
Binding variable which references another variable...
in = 0 -> id = 1 (integer) / label = 'a' (string)
in = 0 -> id = 2 (integer) / label = 'b' (string)
Binding a variable and a value...
in = 0 -> id = 1 (integer) / label = 'a' (string)
in = 0 -> id = 2 (integer) / label = 'b' (string)
Binding a variable to two placeholders and changing the variable value in between the binds...
in = 2 -> id = 1 (integer) / label = 'a' (string)
in = 2 -> id = 2 (integer) / label = 'b' (string)
Binding variable...
in = 0 -> id = 1 (integer) / label = 'a' (string)
in = 0 -> id = 2 (integer) / label = 'b' (string)
Binding value and not variable...
in = 0 -> id = 1 (integer) / label = 'a' (string)
in = 0 -> id = 2 (integer) / label = 'b' (string)
Binding variable which references another variable...
in = 0 -> id = 1 (integer) / label = 'a' (string)
in = 0 -> id = 2 (integer) / label = 'b' (string)
Binding a variable and a value...
in = 0 -> id = 1 (integer) / label = 'a' (string)
in = 0 -> id = 2 (integer) / label = 'b' (string)
Binding a variable to two placeholders and changing the variable value in between the binds...
in = 2 -> id = 1 (integer) / label = 'a' (string)
in = 2 -> id = 2 (integer) / label = 'b' (string)
done!
