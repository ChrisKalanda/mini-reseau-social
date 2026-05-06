-- Données de test
-- Mot de passe pour les deux comptes : Test1234!
USE mini_reseau_social;

INSERT INTO users (username, email, password, bio) VALUES
('alice', 'alice@test.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Photographe amateur'),
('bob',   'bob@test.com',   '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Voyageur passionné');

