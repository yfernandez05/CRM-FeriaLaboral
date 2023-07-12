
--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alertas`
--
ALTER TABLE `alertas`
  ADD PRIMARY KEY (`idalerta`),
  ADD UNIQUE KEY `ak_nombrealerta_alertas` (`nombrealerta`,`estado`),
  ADD KEY `fk_idcampania_alertas` (`idcampania`);

--
-- Indices de la tabla `atenciones`
--
ALTER TABLE `atenciones`
  ADD PRIMARY KEY (`idatencion`),
  ADD KEY `fk_iduser_atenciones` (`iduser`),
  ADD KEY `fk_idtipoatencion_atenciones` (`idtipoatencion`),
  ADD KEY `fk_idcliente_atenciones` (`idcliente`);

--
-- Indices de la tabla `campanias`
--
ALTER TABLE `campanias`
  ADD PRIMARY KEY (`idcampania`),
  ADD UNIQUE KEY `ak_nombrecampania_campanias` (`nombrecampania`,`estado`),
  ADD KEY `fk_idcuenta_campanias` (`idcuenta`);

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`idcarrera`),
  ADD UNIQUE KEY `ak_nombre_carreras` (`nombre`,`estado`);

--
-- Indices de la tabla `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`),
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `chats_tiposala_idx` (`idtiposala`);

--
-- Indices de la tabla `chat_user`
--
ALTER TABLE `chat_user`
  ADD KEY `chat_chat_id` (`chat_chat_id`),
  ADD KEY `user_idcliente` (`user_idcliente`);

--
-- Indices de la tabla `ciclo`
--
ALTER TABLE `ciclo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ak_nombre_carreras` (`nombre`,`estado`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`),
  ADD UNIQUE KEY `ak_email_idcampania_clientes` (`idcampania`,`estado`,`email`) USING BTREE,
  ADD KEY `fk_idcampania_clientes` (`idcampania`);

--
-- Indices de la tabla `cliente_empleo`
--
ALTER TABLE `cliente_empleo`
  ADD PRIMARY KEY (`idcliente_empleo`),
  ADD UNIQUE KEY `unique_cliente_empleo` (`idcliente`,`idempleo`),
  ADD KEY `idempleo` (`idempleo`);

--
-- Indices de la tabla `conectionchat`
--
ALTER TABLE `conectionchat`
  ADD PRIMARY KEY (`idconexion`),
  ADD UNIQUE KEY `ak_nombre_conectionchat` (`idconexion`);

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`idcuenta`),
  ADD UNIQUE KEY `ak_razonsocial_cuentas` (`razonsocial`,`estado`),
  ADD UNIQUE KEY `ak_ruc_cuentas` (`ruc`,`estado`);

--
-- Indices de la tabla `empleos`
--
ALTER TABLE `empleos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idempresa` (`idempresa`);

--
-- Indices de la tabla `empleo_carrera`
--
ALTER TABLE `empleo_carrera`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_empleo_carrera_empleo` (`id_empleo`),
  ADD KEY `fk_empleo_carrera_carrera` (`id_carrera`);

--
-- Indices de la tabla `empleo_ciclo`
--
ALTER TABLE `empleo_ciclo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_empleo` (`id_empleo`),
  ADD KEY `ciclo_id` (`ciclo_id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idempresa`),
  ADD UNIQUE KEY `ak_empresa_cuentas` (`empresa`) USING BTREE;

--
-- Indices de la tabla `estudios`
--
ALTER TABLE `estudios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`idevento`),
  ADD UNIQUE KEY `ak_nombreevento_eventos` (`nombreevento`,`estado`),
  ADD KEY `fk_idcampania_eventos` (`idcampania`),
  ADD KEY `fk_idtipoevento_eventos` (`idtipoevento`);

--
-- Indices de la tabla `evento_cliente`
--
ALTER TABLE `evento_cliente`
  ADD PRIMARY KEY (`ideventocliente`,`idevento`,`idcliente`),
  ADD KEY `fk_idevento_evento_cliente` (`idevento`),
  ADD KEY `fk_idcliente_evento_cliente` (`idcliente`);

--
-- Indices de la tabla `experiencias`
--
ALTER TABLE `experiencias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ak_nombre_carreras` (`nombre`,`estado`);

--
-- Indices de la tabla `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indices de la tabla `historial_laboral`
--
ALTER TABLE `historial_laboral`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indices de la tabla `idiomas`
--
ALTER TABLE `idiomas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cliente_idioma` (`nombre`,`idcliente`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indices de la tabla `importaciones`
--
ALTER TABLE `importaciones`
  ADD PRIMARY KEY (`idimportacion`),
  ADD KEY `fk_iduser_importaciones` (`iduser`);

--
-- Indices de la tabla `logerrors`
--
ALTER TABLE `logerrors`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`,`idcliente`,`chat_id`),
  ADD KEY `fk_messages_idcliente` (`idcliente`),
  ADD KEY `fk_messages_chat_id` (`chat_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idcliente` (`idcliente`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idrol`),
  ADD UNIQUE KEY `ak_rol_roles` (`rol`,`estado`);

--
-- Indices de la tabla `tipoatenciones`
--
ALTER TABLE `tipoatenciones`
  ADD PRIMARY KEY (`idtipoatencion`),
  ADD UNIQUE KEY `ak_tipoatencion_tipoatenciones` (`tipoatencion`,`estado`);

--
-- Indices de la tabla `tipoeventos`
--
ALTER TABLE `tipoeventos`
  ADD PRIMARY KEY (`idtipoevento`),
  ADD UNIQUE KEY `ak_nombreevento_eventos` (`tipoevento`,`estado`);

--
-- Indices de la tabla `tiposala`
--
ALTER TABLE `tiposala`
  ADD PRIMARY KEY (`idtiposala`),
  ADD UNIQUE KEY `ak_nombrealerta_alertas` (`tiposala`);

--
-- Indices de la tabla `ubigeos`
--
ALTER TABLE `ubigeos`
  ADD PRIMARY KEY (`pkubigeo`),
  ADD KEY `fk_fkubigeo_ubigeos` (`fkubigeo`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_token` (`api_token`),
  ADD UNIQUE KEY `ak_email_users` (`email`,`estado`),
  ADD KEY `fk_idrol_users` (`idrol`),
  ADD KEY `fk_idcuenta_users` (`idcuenta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alertas`
--
ALTER TABLE `alertas`
  MODIFY `idalerta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `atenciones`
--
ALTER TABLE `atenciones`
  MODIFY `idatencion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `campanias`
--
ALTER TABLE `campanias`
  MODIFY `idcampania` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `idcarrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ciclo`
--
ALTER TABLE `ciclo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente_empleo`
--
ALTER TABLE `cliente_empleo`
  MODIFY `idcliente_empleo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `conectionchat`
--
ALTER TABLE `conectionchat`
  MODIFY `idconexion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `idcuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `empleos`
--
ALTER TABLE `empleos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT de la tabla `empleo_carrera`
--
ALTER TABLE `empleo_carrera`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=799;

--
-- AUTO_INCREMENT de la tabla `empleo_ciclo`
--
ALTER TABLE `empleo_ciclo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=529;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idempresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT de la tabla `estudios`
--
ALTER TABLE `estudios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `idevento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evento_cliente`
--
ALTER TABLE `evento_cliente`
  MODIFY `ideventocliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `experiencias`
--
ALTER TABLE `experiencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_laboral`
--
ALTER TABLE `historial_laboral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `idiomas`
--
ALTER TABLE `idiomas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `importaciones`
--
ALTER TABLE `importaciones`
  MODIFY `idimportacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `logerrors`
--
ALTER TABLE `logerrors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipoatenciones`
--
ALTER TABLE `tipoatenciones`
  MODIFY `idtipoatencion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipoeventos`
--
ALTER TABLE `tipoeventos`
  MODIFY `idtipoevento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tiposala`
--
ALTER TABLE `tiposala`
  MODIFY `idtiposala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alertas`
--
ALTER TABLE `alertas`
  ADD CONSTRAINT `fk_idcampania_alertas` FOREIGN KEY (`idcampania`) REFERENCES `campanias` (`idcampania`);

--
-- Filtros para la tabla `atenciones`
--
ALTER TABLE `atenciones`
  ADD CONSTRAINT `fk_idcliente_atenciones` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`),
  ADD CONSTRAINT `fk_idtipoatencion_atenciones` FOREIGN KEY (`idtipoatencion`) REFERENCES `tipoatenciones` (`idtipoatencion`),
  ADD CONSTRAINT `fk_iduser_atenciones` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `campanias`
--
ALTER TABLE `campanias`
  ADD CONSTRAINT `fk_idcuenta_campanias` FOREIGN KEY (`idcuenta`) REFERENCES `cuentas` (`idcuenta`);

--
-- Filtros para la tabla `chat_user`
--
ALTER TABLE `chat_user`
  ADD CONSTRAINT `fk_chat_chat_id` FOREIGN KEY (`chat_chat_id`) REFERENCES `chats` (`chat_id`),
  ADD CONSTRAINT `fk_cliente_idcliente` FOREIGN KEY (`user_idcliente`) REFERENCES `clientes` (`idcliente`);

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_idcampania_clientes` FOREIGN KEY (`idcampania`) REFERENCES `campanias` (`idcampania`);

--
-- Filtros para la tabla `cliente_empleo`
--
ALTER TABLE `cliente_empleo`
  ADD CONSTRAINT `cliente_empleo_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`),
  ADD CONSTRAINT `cliente_empleo_ibfk_2` FOREIGN KEY (`idempleo`) REFERENCES `empleos` (`id`);

--
-- Filtros para la tabla `empleos`
--
ALTER TABLE `empleos`
  ADD CONSTRAINT `empleos_ibfk_1` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`idempresa`);

--
-- Filtros para la tabla `empleo_carrera`
--
ALTER TABLE `empleo_carrera`
  ADD CONSTRAINT `fk_empleo_carrera_carrera` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`idcarrera`),
  ADD CONSTRAINT `fk_empleo_carrera_empleo` FOREIGN KEY (`id_empleo`) REFERENCES `empleos` (`id`);

--
-- Filtros para la tabla `empleo_ciclo`
--
ALTER TABLE `empleo_ciclo`
  ADD CONSTRAINT `empleo_ciclo_ibfk_1` FOREIGN KEY (`id_empleo`) REFERENCES `empleos` (`id`),
  ADD CONSTRAINT `empleo_ciclo_ibfk_2` FOREIGN KEY (`ciclo_id`) REFERENCES `ciclo` (`id`);

--
-- Filtros para la tabla `estudios`
--
ALTER TABLE `estudios`
  ADD CONSTRAINT `estudios_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`);

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `fk_idcampania_eventos` FOREIGN KEY (`idcampania`) REFERENCES `campanias` (`idcampania`),
  ADD CONSTRAINT `fk_idtipoevento_eventos` FOREIGN KEY (`idtipoevento`) REFERENCES `tipoeventos` (`idtipoevento`);

--
-- Filtros para la tabla `evento_cliente`
--
ALTER TABLE `evento_cliente`
  ADD CONSTRAINT `fk_idcliente_evento_cliente` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`),
  ADD CONSTRAINT `fk_idevento_evento_cliente` FOREIGN KEY (`idevento`) REFERENCES `eventos` (`idevento`);

--
-- Filtros para la tabla `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historial_laboral`
--
ALTER TABLE `historial_laboral`
  ADD CONSTRAINT `historial_laboral_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`);

--
-- Filtros para la tabla `idiomas`
--
ALTER TABLE `idiomas`
  ADD CONSTRAINT `idiomas_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`);

--
-- Filtros para la tabla `importaciones`
--
ALTER TABLE `importaciones`
  ADD CONSTRAINT `fk_iduser_importaciones` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_messages_chat_id` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`chat_id`),
  ADD CONSTRAINT `fk_messages_idcliente` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`);

--
-- Filtros para la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD CONSTRAINT `perfiles_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_idcuenta_users` FOREIGN KEY (`idcuenta`) REFERENCES `cuentas` (`idcuenta`),
  ADD CONSTRAINT `fk_idrol_users` FOREIGN KEY (`idrol`) REFERENCES `roles` (`idrol`);
