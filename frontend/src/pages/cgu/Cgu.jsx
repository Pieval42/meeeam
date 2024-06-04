/* eslint-disable react/no-unescaped-entities */
import Container from "react-bootstrap/esm/Container";
import Card from "react-bootstrap/esm/Card";
import { Link } from "react-router-dom";
import Col from "react-bootstrap/esm/Col";

export default function Cgu() {
  return (
    <Container className="accueil p-0 w-100">
      <Card className="h-100 w-100 m-0">
        <Card.Header className="row d-flex justify-content-start align-items-center w-100 m-0 p-4">
          <Col xs={2} className="m-0 p-0 text-start">
            <Link to={"/"} className="text-start">
              <Card.Img
                src="/images/logo.svg"
                alt="Banniere Meeeam"
                className="logo-small"
                id="logo-banniere-accueil"
              />
            </Link>
          </Col>
          <Col xs={10} sm={9} md={8} className="m-0 p-0">
            <h1>Conditions Générales d'Utilisation</h1>
          </Col>
        </Card.Header>
        <Card.Body className="text-start">
          <h2>1. Informations Légales</h2>

          <h3>Propriétaire du site :</h3>
          <ul>
            <p>
              Ce site est édité par Meeeam, SARL au capital de 1000€ <br />
              Siège social : 1 rue Fictive, 42600 MONTBRISON <br />
              SIRET 000 000 000 00000
              <br />
              RCS Saint-Etienne 000 000 000
              <br />
              Numéro de téléphone : 00.00.00.00.00
              <br />
              Adresse e-mail : meeeam@exemple.fr
            </p>
          </ul>

          <h3>Directeur de la publication :</h3>
          <ul>
            <p>Nom : Pierrick Valentin</p>
            <p>Adresse e-mail : pierrick.valentin@exemple.fr</p>
          </ul>

          <h3>Hébergeur du site :</h3>
          <ul>
            <p>Nom de l'hébergeur : SuperHébergeur</p>
            <p>Adresse de l'hébergeur : 1 rue Fictive, 75000 PARIS</p>
          </ul>

          <h2>2. Description des Services</h2>
          <p>
            Le site Meeeam (ci-après "le Site") est un réseau social destiné aux
            acteurs du monde de la musique, amateurs ou professionnels
            (musiciens, programmateurs, professeurs de musique, techniciens,
            fabricants ou revendeurs de matériel musical...) permettant à ses
            utilisateurs de partager des photos, des fichiers audio, des vidéos,
            publier des articles, discuter en ligne.
          </p>

          <h2>3. Accès au Site</h2>
          <p>
            L'accès et l'utilisation du Site sont soumis aux présentes
            conditions Gérales (ci-après "CG" ou "CGU") ainsi qu'aux lois et/ou
            règlements applicables. En accédant au Site, l'utilisateur accepte
            sans réserve les présentes conditions générales d'utilisation.
          </p>

          <h2>4. Propriété Intellectuelle</h2>
          <p>
            L'ensemble des contenus présents sur le Site (textes, images,
            vidéos, logos, etc.) sont la propriété exclusive de Meeeam ou sont
            utilisés avec l'autorisation de leurs propriétaires. Toute
            reproduction, distribution, modification ou utilisation de ces
            contenus, sans l'accord préalable écrit de Meeeam, est strictement
            interdite.
          </p>

          <h2>5. Données Personnelles</h2>
          <p>
            Conformément à la loi Informatique et Libertés du 6 janvier 1978
            modifiée et au RGPD, l'utilisateur dispose d'un droit d'accès, de
            rectification, de suppression et d'opposition aux données
            personnelles le concernant. Pour exercer ce droit, l'utilisateur
            peut contacter Meeeam à l'adresse suivante : meeeam@exemple.fr.
          </p>
          <p>
            Le Site s'engage à protéger les données personnelles des
            utilisateurs et à les utiliser uniquement dans le cadre de
            l'utilisation du Site. Les données ne seront pas partagées avec des
            tiers sans le consentement de l'utilisateur, sauf obligations
            légales.
          </p>

          <h2>6. Compte utilisateur</h2>
          <p>
            L'Utilisateur inscrit au Site (membre) a la possibilité d'y accéder
            en se connectant grâce à ses identifiants (adresse e-mail définie
            lors de son inscription et mot de passe). L'utilisateur est
            entièrement responsable de la protection du mot de passe qu’il a
            choisi. Il est encouragé à utiliser des mots de passe complexes. En
            cas d'oubli du mot de passe, l'Utilisateur a la possibilité d'en
            générer un nouveau. Ce mot de passe constitue la garantie de la
            confidentialité des informations contenues dans sa rubrique « mon
            compte » et l'Utilisateur s’interdit donc de le transmettre ou de le
            communiquer à un tiers. A défaut, l'Editeur du Site ne pourra être
            tenu pour responsable des accès non autorisés au compte d'un
            Utilisateur.
          </p>

          <p>
            La création d'un espace personnel est un préalable indispensable à
            toute contribution de l'Utilisateur sur le présent Site. A cette
            fin, l'Utilisateur sera invité à fournir un certain nombre
            d'informations personnelles. Il s’engage à fournir des informations
            exactes.
          </p>

          <p>
            La collecte des données a pour objet la création d'un « compte
            utilisateur ». Ce compte permet à l'Utilisateur de consulter ses
            contributions et celles des autres Utilisateurs lui ayant
            donnél'autorisation. Si les données contenues dans la rubrique
            compte utilisateur venaient à disparaître à la suite d'une panne
            technique ou d'un cas de force majeure, la responsabilité du Site et
            de son Editeur ne pourrait être engagée, ces informations n’ayant
            aucune valeur probante mais uniquement un caractère informatif. Les
            pages relatives aux comptes utilisateur sont librement imprimables
            par le titulaire du compte en question mais ne constituent nullement
            une preuve, elles n’ont qu’un caractère informatif destiné à assurer
            une gestion efficace du service ou des contributions par
            l'Utilisateur.
          </p>

          <p>
            Chaque Utilisateur est libre de fermer son compte et ses données sur
            le Site. Pour ceci, il doit utiliser l'option de suppression de
            compte disponible dans son espace utilisateur. Aucune récupération
            de ses données ne sera alors possible.
          </p>

          <p>
            L'Editeur se réserve le droit exclusif de supprimer le compte de
            tout Utilisateur qui aurait contrevenu aux présentes CG (notamment,
            mais sans que cet exemple n’ait un quelconque caractère exhaustif,
            lorsque l'Utilisateur aura fourni sciemment des informations
            erronées, lors de son inscription et de la constitution de son
            espace personnel) ou encore tout compte inactif depuis au moins une
            année. Ladite suppression ne sera pas susceptible de constituer un
            dommage pour l'Utilisateur exclu qui ne pourra prétendre à aucune
            indemnité de ce fait. Cette exclusion n’est pas exclusive de la
            possibilité, pour l'Editeur, d'entreprendre des poursuites d'ordre
            judiciaire à l'encontre de l'Utilisateur, lorsque les faits l'auront
            justifié.
          </p>

          <h2>7. Cookies</h2>
          <p>
            Un « Cookie » peut permettre l'identification de l'Utilisateur du
            Site, la personnalisation de sa consultation du Site et de
            l'affichage du Site grâce à l'enregistrement d'un fichier de données
            sur son ordinateur. Le Site est susceptible d'utiliser des « Cookies
            » principalement pour :<br />
            1) permettre l'accès à un compte de membre et à du contenu qui n’est
            pas accessible sans connexion, et <br />
            2) améliorer l'expérience de l'Utilisateur.
            </p>
            <p>
            L'Utilisateur reconnaît être informé de cette pratique et autorise
            l'Editeur du Site à y recourir. L'Editeur s’engage à ne jamais
            communiquer le contenu de ces « Cookies » à des tierces personnes,
            sauf en cas de réquisition légale. L'Utilisateur peut refuser
            l'enregistrement de « Cookies » ou configurer son navigateur pour
            être prévenu préalablement à l'acception des « Cookies ». Pour ce
            faire, l'Utilisateur peut procéder au paramétrage de son navigateur.
          </p>

          <h2>8. Responsabilité</h2>
          <p>
            Meeeam décline toute responsabilité quant à l'utilisation qui
            pourrait être faite des informations et contenus présents sur le
            Site. Le Site peut contenir des liens vers d'autres sites dont
            Meeeam n'exerce aucun contrôle. Meeeam décline toute responsabilité
            quant aux contenus de ces sites.
          </p>
          <p>
            L'Editeur n’est pas responsable des publications des Utilisateurs,
            de leur contenu ainsi que de leur véracité. L'Editeur ne peut en
            aucun cas être tenu responsable de tout dommage susceptible
            d'intervenir sur le système informatique de l'Utilisateur et/ou de
            la perte de données résultant de l'utilisation du Site par
            l'Utilisateur.
          </p>
          <p>
            L'Editeur s’engage à constamment mettre à jour le contenu du Site et
            à fournir aux Utilisateurs des informations justes, claires,
            précises et réactualisées. Le Site est en principe accessible en
            permanence, sauf pendant les opérations techniques de maintenance et
            de mise à jour du contenu.
          </p>
          <p>
            L'Editeur ne saurait être tenu responsable de dommages résultant de
            l'indisponibilité du Site ou de parties de celui-ci. La
            responsabilité de l'Editeur du Site ne peut être engagée en raison
            d'une indisponibilité technique de la connexion, qu’elle soit due
            notamment à un cas de force majeure, à une maintenance, à une mise à
            jour, à une modification du Site, à une intervention de l'hébergeur,
            à une grève interne ou externe, à une panne de réseau, ou encore à
            une coupure d'alimentation électrique.
          </p>

          <h2>9. Droit Applicable et Juridiction Compétente</h2>
          <p>
            Les présentes CGU sont régies par le droit français. En cas de
            litige, et à défaut de résolution amiable, les tribunaux français
            seront seuls compétents.
          </p>

          <h2>10. Modification des CGU</h2>
          <p>
            Meeeam se réserve le droit de modifier les présentes CGU à tout
            moment. Les utilisateurs sont invités à les consulter régulièrement.
          </p>

          <h2>11. Contact</h2>
          <p>
            Pour toute question ou information concernant les CGU, vous pouvez
            contacter Meeeam à l'adresse suivante : meeeam@exemple.fr
          </p>
        </Card.Body>
        <Card.Footer>
          <Link to={"/"} className="nav-link text-start">
            {"< Retour"}
          </Link>
        </Card.Footer>
      </Card>
    </Container>
  );
}
