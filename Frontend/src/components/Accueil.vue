<script setup>
import StudentsCards from './StudentsCards.vue';

</script>

<template>
    <div class="Main bg-light">
      <div class="h4 text-center bg-primary text-white py-3 W-100">
          Linus University
      </div>
      <div class="accueil_phrase">
                <h1>
          Nos Personnages
        </h1>
        
        <div> 
          Bienvenue a Linus University, un endroit fantastique ou toute personne est libre de devenir qui elle souhaite devenir !
          <br/>
          Voici quelques têtes que vous risquez de rencontrer ici :
        </div>

      </div>
      <div class="tab_pres">
        <StudentsCards CharText="Firefox ! Rapide, flexible, il s'entend bien avec tout le monde !" CharName="FireFox" CharImg="/images/characters/firefox-neutral.png"></StudentsCards>
        <StudentsCards CharText="LibreOffice. Secrétaire général, il gère les mots, les tableaux, les présentations... Il se considère comme une suite complète." CharName="LibreOffice" CharImg="/images/characters/libreoffice-neutral.png"></StudentsCards>
        <StudentsCards CharText="VLC ! Elle mange tout : MP4, MKV, AVI, FLV... et même les fichiers corrompus ! Tu as un fichier corrompu ? Elle peux le lire ! " CharName="VLC" CharImg="/images/characters/vlc-neutral.png"></StudentsCards>
        <StudentsCards CharText="Audacity ! Si tu as du bruit de fond dans ta vie, elle le coupe ; normalize tes fréquences, et bien plus !" CharName="Audacity" CharImg="/images/characters/audacity-neutral.png"></StudentsCards>
        <StudentsCards CharText="Elle est stable, très stable, peut être même un peu trop, Debian ! l'Atlas moderne !" CharName="Debian" CharImg="/images/characters/debian-neutral.png"></StudentsCards>
        <StudentsCards CharText="FFmpeg ! Loin d'être sociable, ne la fixer pas trop longtemps ou elle risque de perdre 'des frames' " CharName="FFmpeg" CharImg="/images/characters/ffmpeg-neutral.png"></StudentsCards>
        <StudentsCards CharText="OBS, ta streameuse préférée ! Elle capture tout ce qui se passe ici en temps réel ! Dis bonjour à la caméra !" CharName="OBS" CharImg="/images/characters/obs-neutral.png"></StudentsCards>
      </div>
    </div>
</template>


<style scoped>

    .accueil_phrase{

      width: 80%;
      max-width: calc(300px * 3);
      font-size: large;
      margin-left: auto;
      margin-right: auto;
      margin-top: 20px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .accueil_phrase h1{
      color: var(--bs-primary);
      text-align: center;
    }

    .accueil_phrase div{
      font-weight: 500;
      text-align: center;
    }

    .Main{
        display: flex;
        flex-direction: column;
        
      }

.tab_pres {
    width: 80%;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 2fr));
    max-width: calc(300px * 3);
    gap: 20px;
    margin-bottom: 50px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 10px;
}

</style>