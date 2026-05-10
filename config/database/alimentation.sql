NSERT INTO `agences` (`id`, `nom`) VALUES
(1, 'Paris'),
(2, 'Lyon'),
(3, 'Marseille'),
(4, 'Toulouse'),
(5, 'Nice'),
(6, 'Nantes'),
(7, 'Strasbourg'),
(8, 'Montpellier'),
(9, 'Bordeaux'),
(10, 'Lille'),
(11, 'Rennes'),
(12, 'Reims'),
(13, 'Dijon'),
(14, 'Dijon');


INSERT INTO `reservations` (`id`, `user_id`, `trajet_id`, `nombre_places`, `date_reservation`) VALUES
(3, 1, 2, 1, '2026-05-09 22:25:04'),
(4, 1, 2, 1, '2026-05-09 22:27:22');


INSERT INTO `trajets` (`id`, `depart_agence_id`, `arrivee_agence_id`, `date_depart`, `date_arrivee`, `places_total`, `places_disponibles`, `user_id`) VALUES
(2, 1, 2, '2025-06-20 08:00:00', '2025-06-20 12:00:00', 4, 3, 1),
(3, 2, 3, '2025-06-21 09:30:00', '2025-06-21 13:30:00', 5, 2, 2),
(4, 3, 1, '2025-06-22 14:00:00', '2025-06-22 18:00:00', 3, 1, 3),
(5, 1, 2, '2026-05-05 11:00:00', '2026-05-05 14:00:00', 4, 4, 1);

INSERT INTO `users` (`id`, `nom`, `prenom`, `telephone`, `email`, `password`, `role`) VALUES
(1, 'Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', '123456', 'admin'),
(2, 'Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', '$2y$10$GNrdmyxnkFw.tF65kbMKjOiCfYQAzHnYMx/YNxyPaqDIN6OulGczy', 'user'),
(3, 'Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', '$2y$10$GNrdmyxnkFw.tF65kbMKjOiCfYQAzHnYMx/YNxyPaqDIN6OulGczy', 'user'),
(4, 'Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', '$2y$10$GNrdmyxnkFw.tF65kbMKjOiCfYQAzHnYMx/YNxyPaqDIN6OulGczy', 'user'),
(5, 'Lefevre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', '$2y$10$GNrdmyxnkFw.tF65kbMKjOiCfYQAzHnYMx/YNxyPaqDIN6OulGczy', 'user');
