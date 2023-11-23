import {
  PerspectiveCamera,
  Environment,
  OrbitControls,
} from "@react-three/drei";
import { Canvas } from "@react-three/fiber";

const CabinetEnv = (props: { url: string[] | undefined }) => {
  const photos = props.url;
  console.log("photos", photos);
  return <Environment files={photos} background />;
};

const SinglePanorama = (props: { url: string[] | undefined }) => {
  const {
    url = [
      "/uploads/panorama/px.png",
      "/uploads/panorama/nx.png",
      "/uploads/panorama/py.png",
      "/uploads/panorama/ny.png",
      "/uploads/panorama/pz.png",
      "/uploads/panorama/nz.png",
    ],
  } = props;
  return (
    <Canvas camera={{ position: [100, 1, 1] }}>
      <CabinetEnv url={url} />
      <OrbitControls makeDefault target={[0, 1, 0]} />
      <PerspectiveCamera fov={90} position={[-4, 4, 4]} makeDefault />
    </Canvas>
  );
};

export default SinglePanorama;
